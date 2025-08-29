<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\StudentAnswer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamResult;

class GuruDataUjianSiswaController extends Controller
{
    // Daftar semua ujian yang dibuat oleh user login
    public function index()
    {
        $user = Auth::user();

        // Ambil ujian yang dibuat oleh user login
        $exams = Exam::where('user_id', $user->id)
                     ->latest()
                     ->get();

        return view('guru.data-ujian-siswa.index', compact('exams'));
    }

    // Tampilkan nilai siswa per ujian, hanya siswa dari kelas ujian itu
    public function show($examId, Request $request)
    {
        $user = Auth::user();

        // Pastikan ujian ini dibuat oleh user login
        $exam = Exam::where('id', $examId)
                    ->where('user_id', $user->id)
                    ->firstOrFail();

        // Ambil kelas ujian
        $examKelas = $exam->kelas; // contoh: "X", "XI", "XII"

        // Ambil siswa yang ada di kelas ujian
        $siswas = Siswa::with(['user', 'kelas'])
                    ->where('kelas_id', function($q) use ($examKelas) {
                        $q->select('id')
                          ->from('kelas')
                          ->where('nama_kelas', $examKelas)
                          ->limit(1);
                    })
                    ->when($request->jurusan, fn($q) => $q->where('jurusan', $request->jurusan))
                    ->when($request->kode_kelas, fn($q) => $q->where('kode_kelas', $request->kode_kelas))
                    ->get();

        // Ambil hasil ujian siswa dari exam_result
        $results = ExamResult::where('exam_id', $examId)
                    ->get()
                    ->keyBy('student_id');

        $kelasList = Kelas::all();
        $jurusanList = Siswa::select('jurusan')->distinct()->pluck('jurusan');

        return view('guru.data-ujian-siswa.show', compact(
            'exam', 'siswas', 'results', 'kelasList', 'jurusanList'
        ));
    }

    // Export nilai siswa ke Excel
    public function export($examId, Request $request)
    {
        $user = Auth::user();

        $exam = Exam::where('id', $examId)
                    ->where('user_id', $user->id)
                    ->firstOrFail();

        $examKelas = $exam->kelas;

        // Ambil siswa yang ada di kelas ujian
        $siswas = Siswa::with(['user', 'kelas'])
                    ->where('kelas_id', function($q) use ($examKelas) {
                        $q->select('id')
                          ->from('kelas')
                          ->where('nama_kelas', $examKelas)
                          ->limit(1);
                    })
                    ->when($request->jurusan, fn($q) => $q->where('jurusan', $request->jurusan))
                    ->when($request->kode_kelas, fn($q) => $q->where('kode_kelas', $request->kode_kelas))
                    ->get();

       // Ambil hasil ujian siswa dari exam_result
        $results = ExamResult::where('exam_id', $examId)
                    ->get()
                    ->keyBy('student_id');

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
            $res = $results[$siswa->user_id] ?? null;

            $sheet->setCellValue('A'.$row, $no++)
                  ->setCellValue('B'.$row, $siswa->user->name ?? 'Belum memiliki akun')
                  ->setCellValue('C'.$row, $siswa->kelas->nama_kelas ?? '-')
                  ->setCellValue('D'.$row, $siswa->kode_kelas ?? '-')
                  ->setCellValue('E'.$row, $siswa->jurusan ?? '-')
                  ->setCellValue('F'.$row, $res->score ?? 0)
                  ->setCellValue(
                        'G'.$row, 
                        $res ? \Carbon\Carbon::parse($res->created_at)->format('d-m-Y') : '-'
                    );

            $row++;
        }

        $writer = new Xlsx($spreadsheet);

$fileName = 'Nilai_ujian_'.$exam->title;

// gunakan kelas dari exam langsung
if ($examKelas) {
    $fileName .= '_kelas_'.$examKelas;
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
