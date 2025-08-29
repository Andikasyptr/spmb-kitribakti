<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Siswa;
use App\Models\Kelas;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataUjianSiswaController extends Controller
{
    // Daftar semua ujian
    public function index()
    {
        $exams = Exam::all();
        return view('admin.data-ujian-siswa.index', compact('exams'));
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
}
