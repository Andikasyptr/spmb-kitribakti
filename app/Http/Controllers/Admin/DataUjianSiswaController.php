<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Siswa;
use App\Models\Kelas;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\StudentAnswer;
use App\Models\ExamResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataUjianSiswaController extends Controller
{
    // Daftar semua ujian
   // Daftar semua ujian + fitur pencarian + urut A-Z
    public function index(Request $request)
    {
        $search = $request->input('search'); // ambil input pencarian

        $exams = Exam::when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title', 'asc') // urutkan A-Z
            ->get();

        $kelas = Kelas::all();

        return view('admin.data-ujian-siswa.index', compact('exams', 'kelas', 'search'));
    }
    // Tampilkan nilai siswa per ujian
    public function show($examId, Request $request)
    {
        $exam = Exam::findOrFail($examId);

        $siswas = Siswa::with(['user', 'kelas'])
            ->when($request->kelas_id, fn($q) => $q->where('kelas_id', $request->kelas_id))
            ->when($request->jurusan, fn($q) => $q->where('jurusan', $request->jurusan))
            ->when($request->kode_kelas, fn($q) => $q->where('kode_kelas', $request->kode_kelas))
            ->get();

        $results = ExamResult::where('exam_id', $examId)->get()->keyBy('student_id');

        $kelasList = Kelas::all();
        $jurusanList = Siswa::select('jurusan')->distinct()->pluck('jurusan');

        return view('admin.data-ujian-siswa.show', compact(
            'exam', 'siswas', 'results', 'kelasList', 'jurusanList'
        ));
    }

    // Export nilai siswa per ujian ke Excel
    public function export($examId, Request $request)
    {
        $exam = Exam::findOrFail($examId);

        $siswas = Siswa::with(['user', 'kelas'])
            ->when($request->kelas_id, fn($q) => $q->where('kelas_id', $request->kelas_id))
            ->when($request->jurusan, fn($q) => $q->where('jurusan', $request->jurusan))
            ->when($request->kode_kelas, fn($q) => $q->where('kode_kelas', $request->kode_kelas))
            ->get();

        $results = ExamResult::where('exam_id', $examId)->get()->keyBy('student_id');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No')
              ->setCellValue('B1', 'Nama Siswa')
              ->setCellValue('C1', 'Kelas')
              ->setCellValue('D1', 'Kode Kelas')
              ->setCellValue('E1', 'Jurusan')
              ->setCellValue('F1', 'Nilai')
              ->setCellValue('G1', 'Tanggal');

        $row = 2;
        $no = 1;
        foreach ($siswas as $siswa) {
            $userId = $siswa->user->id ?? null;
            $res = $userId ? ($results[$userId] ?? null) : null;

            $sheet->setCellValue('A'.$row, $no++)
                  ->setCellValue('B'.$row, $siswa->user->name ?? 'Belum memiliki akun')
                  ->setCellValue('C'.$row, $siswa->kelas->nama_kelas ?? '-')
                  ->setCellValue('D'.$row, $siswa->kode_kelas ?? '-')
                  ->setCellValue('E'.$row, $siswa->jurusan ?? '-')
                  ->setCellValue('F'.$row, $res->score ?? 0)
                  ->setCellValue('G'.$row, $res ? $res->created_at->format('d-m-Y') : '-');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        // Nama file dinamis
        $fileName = 'Nilai_ujian_'.$exam->title;
        if ($request->kelas_id) {
            $kelas = Kelas::find($request->kelas_id);
            if ($kelas) $fileName .= '_kelas_'.$kelas->nama_kelas;
        }
        if ($request->jurusan) {
            $fileName .= '_jurusan_'.$request->jurusan;
        }
        if ($request->kode_kelas) {
            $fileName .= '_kode_'.$request->kode_kelas;
        }
        $fileName .= '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        $writer->save("php://output");
        exit;
    }
    public function deleteStudentAnswer($examId, $studentId)
    {
        DB::beginTransaction();
        try {
            // 🔹 Hapus jawaban siswa
            $deletedAnswers = StudentAnswer::where('exam_id', $examId)
                ->where('student_id', $studentId)
                ->delete();

            // 🔹 Hapus hasil ujian siswa
            $deletedResult = ExamResult::where('exam_id', $examId)
                ->where('student_id', $studentId)
                ->delete();

            DB::commit();

            return back()->with('success', "Data jawaban ($deletedAnswers) dan hasil ujian siswa berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }
    

public function deleteMultipleStudentAnswers(Request $request, $examId)
{
    // Ambil student_ids dari request
    $studentIds = $request->input('student_ids', []);

    // Jika dikirim sebagai string, ubah menjadi array
    if (is_string($studentIds)) {
        $studentIds = explode(',', $studentIds);
    }

    // Cek kosong
    if (empty($studentIds)) {
        return back()->with('error', 'Pilih minimal satu siswa untuk dihapus.');
    }

    DB::beginTransaction();
    try {
        // 🔹 Hapus jawaban siswa
        $deletedAnswers = StudentAnswer::where('exam_id', $examId)
            ->whereIn('student_id', $studentIds)
            ->delete();

        // 🔹 Hapus hasil ujian siswa
        $deletedResults = ExamResult::where('exam_id', $examId)
            ->whereIn('student_id', $studentIds)
            ->delete();

        DB::commit();

        return back()->with('success', "Data jawaban ($deletedAnswers) dan hasil ujian siswa berhasil dihapus.");
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
    }
}


public function deleteAllStudentAnswers($examId)
{
    DB::beginTransaction();
    try {
        // 🔹 Hapus semua jawaban siswa di ujian ini
        $deletedAnswers = StudentAnswer::where('exam_id', $examId)->delete();

        // 🔹 Hapus semua hasil ujian siswa di ujian ini
        $deletedResults = ExamResult::where('exam_id', $examId)->delete();

        DB::commit();

        return back()->with('success', "Semua jawaban ($deletedAnswers) dan hasil ujian siswa berhasil dihapus.");
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
    }
}

public function viewStudentAnswers($examId, $studentId)
{
    $exam = Exam::with('questions.options')->findOrFail($examId);

    // Ambil semua jawaban siswa
    $studentAnswers = StudentAnswer::where('exam_id', $examId)
                        ->where('student_id', $studentId)
                        ->get()
                        ->keyBy('question_id'); // supaya mudah diakses per soal

    return view('admin.data-ujian-siswa.view-answers', compact('exam', 'studentAnswers'));
}




}
