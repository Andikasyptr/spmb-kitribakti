<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Exam;

class ExamResultController extends Controller
{
    // Menampilkan nilai siswa untuk ujian tertentu
    public function showResults($examId)
    {
        $results = ExamResult::with('student')
                    ->where('exam_id', $examId)
                    ->get();

        return view('admin.exam_results', [
            'exam' => Exam::findOrFail($examId),
            'results' => $results
        ]);
    }

    // Tambahan: export Excel (opsional)
    public function exportExcel($examId)
    {
        // bisa pakai package Maatwebsite\Excel
        // Contoh:
        // return Excel::download(new ExamResultExport($examId), 'nilai-ujian.xlsx');
    }
}
