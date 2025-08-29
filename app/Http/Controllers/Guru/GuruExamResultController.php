<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Exam;

class GuruExamResultController extends Controller
{
    /**
     * Menampilkan nilai siswa untuk ujian tertentu milik guru
     */
    public function showResults($examId)
    {
        $exam = Exam::findOrFail($examId);

        // Pastikan ujian ini milik guru yang login
        if ($exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $results = ExamResult::with('student')
                    ->where('exam_id', $examId)
                    ->get();

        return view('guru.e-learning.exam_results', [
            'exam' => $exam,
            'results' => $results
        ]);
    }

    /**
     * Export nilai siswa ke Excel (opsional)
     */
    public function exportExcel($examId)
    {
        $exam = Exam::findOrFail($examId);

        if ($exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Implementasi export Excel bisa menggunakan package Maatwebsite\Excel
        // Contoh:
        // return Excel::download(new \App\Exports\ExamResultExport($examId), 'nilai-ujian.xlsx');
    }
}
