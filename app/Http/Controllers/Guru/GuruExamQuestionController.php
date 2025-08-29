<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GuruExamQuestionController extends Controller
{
    /**
     * List soal
     */
    public function index(Exam $exam)
    {
        $questions = ExamQuestion::with('options')
            ->where('exam_id', $exam->id)
            ->get();

        return view('guru.e-learning.questions.index', compact('exam', 'questions'));
    }

    /**
     * Form tambah soal
     */
    public function create(Exam $exam)
    {
        $questions = ExamQuestion::with('options')
            ->where('exam_id', $exam->id)
            ->get();

        return view('guru.e-learning.questions.create', compact('exam', 'questions'));
    }

    /**
     * Simpan pertanyaan baru ke dalam ujian
     */
    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text'  => 'required|string',
            'questions.*.point'          => 'required|integer|min:1',
            'questions.*.options'        => 'required|array|size:5',
            'questions.*.correct_answer' => 'required|string|in:A,B,C,D,E',
        ]);

        foreach ($request->questions as $qIndex => $q) {
            $imagePath = null;
            if ($request->hasFile("questions.$qIndex.image")) {
                $imagePath = $request->file("questions.$qIndex.image")->store("questions", "public");
            }

            $question = ExamQuestion::create([
                'exam_id'       => $exam->id,
                'question_text' => $q['question_text'],
                'point'         => $q['point'],
                'question_type' => 'multiple_choice',
                'image_path'    => $imagePath,
            ]);

            foreach ($q['options'] as $label => $optData) {
                $optionText = is_array($optData) ? ($optData['text'] ?? '') : $optData;
                $optImage = null;

                if ($request->hasFile("questions.$qIndex.options.$label.image")) {
                    $optImage = $request->file("questions.$qIndex.options.$label.image")->store("options", "public");
                }

                ExamQuestionOption::create([
                    'exam_question_id' => $question->id,
                    'option_label'     => $label,
                    'option_text'      => $optionText,
                    'is_correct'       => ($label === $q['correct_answer']),
                    'image_path'       => $optImage,
                ]);
            }
        }

        return redirect()
            ->route('guru.exam-questions.index', $exam->id)
            ->with('success', 'Semua soal berhasil disimpan.');
    }

    /**
     * Form edit semua soal
     */
    public function editAll(Exam $exam)
    {
        
        
        $questions = ExamQuestion::with('options')
            ->where('exam_id', $exam->id)
            ->get();

        return view('guru.e-learning.questions.edit-all', compact('exam', 'questions'));
    }

    /**
     * Update semua soal dan opsi
     */
    public function updateAll(Request $request, Exam $exam)
    {
         // Hapus soal yang ditandai di form
    if ($request->has('deleted_questions')) {
        ExamQuestion::whereIn('id', $request->deleted_questions)->delete();
    }
        foreach ($request->input('questions', []) as $qIndex => $qData) {
            if (empty($qData['id'])) continue;

            $question = ExamQuestion::find($qData['id']);
            if ($question) {
                $updateData = [
                    'question_text' => $qData['question_text'] ?? '',
                    'point'         => $qData['point'] ?? 1,
                ];

                if ($request->hasFile("questions.$qIndex.image")) {
                    if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
                        Storage::disk('public')->delete($question->image_path);
                    }
                    $updateData['image_path'] = $request->file("questions.$qIndex.image")->store("questions", "public");
                }

                $question->update($updateData);

                // reset jawaban benar
                ExamQuestionOption::where('exam_question_id', $question->id)
                    ->update(['is_correct' => false]);

                if (!empty($qData['options']) && is_array($qData['options'])) {
                    foreach ($qData['options'] as $label => $optData) {
                        $option = ExamQuestionOption::where('exam_question_id', $question->id)
                            ->where('option_label', $label)
                            ->first();

                        if ($option) {
                            $optionText = is_array($optData) ? ($optData['text'] ?? '') : $optData;

                            $optUpdate = [
                                'option_text' => $optionText,
                                'is_correct'  => (!empty($qData['correct_answer']) && $qData['correct_answer'] === $label),
                            ];

                            if ($request->hasFile("questions.$qIndex.options.$label.image")) {
                                if ($option->image_path && Storage::disk('public')->exists($option->image_path)) {
                                    Storage::disk('public')->delete($option->image_path);
                                }
                                $optUpdate['image_path'] = $request->file("questions.$qIndex.options.$label.image")->store("options", "public");
                            }

                            $option->update($optUpdate);
                        }
                    }
                }
            }
        }

        // Soal baru
        foreach ($request->input('new_questions', []) as $nIndex => $new) {
            if (empty($new['question_text'])) continue;

            $newImage = null;
            if ($request->hasFile("new_questions.$nIndex.image")) {
                $newImage = $request->file("new_questions.$nIndex.image")->store("questions", "public");
            }

            $question = ExamQuestion::create([
                'exam_id'       => $exam->id,
                'question_text' => $new['question_text'],
                'point'         => $new['point'] ?? 1,
                'question_type' => 'multiple_choice',
                'image_path'    => $newImage,
            ]);

            if (!empty($new['options']) && is_array($new['options'])) {
                foreach ($new['options'] as $label => $optData) {
                    $optionText = is_array($optData) ? ($optData['text'] ?? '') : $optData;
                    $optImage = null;

                    if ($request->hasFile("new_questions.$nIndex.options.$label.image")) {
                        $optImage = $request->file("new_questions.$nIndex.options.$label.image")->store("options", "public");
                    }

                    ExamQuestionOption::create([
                        'exam_question_id' => $question->id,
                        'option_label'     => $label,
                        'option_text'      => $optionText,
                        'is_correct'       => (!empty($new['correct_answer']) && $new['correct_answer'] === $label),
                        'image_path'       => $optImage,
                    ]);
                }
            }
        }

        return redirect()
            ->route('guru.exam-questions.index', $exam->id)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Download template Excel soal
     */
    public function downloadTemplate(Exam $exam)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Pertanyaan')
              ->setCellValue('B1', 'Poin')
              ->setCellValue('C1', 'Opsi A')
              ->setCellValue('D1', 'Opsi B')
              ->setCellValue('E1', 'Opsi C')
              ->setCellValue('F1', 'Opsi D')
              ->setCellValue('G1', 'Opsi E')
              ->setCellValue('H1', 'Jawaban Benar (A/B/C/D/E)');

        $sheet->setCellValue('A2', 'Contoh Pertanyaan')
              ->setCellValue('B2', 10)
              ->setCellValue('C2', 'Opsi A')
              ->setCellValue('D2', 'Opsi B')
              ->setCellValue('E2', 'Opsi C')
              ->setCellValue('F2', 'Opsi D')
              ->setCellValue('G2', 'Opsi E')
              ->setCellValue('H2', 'A');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_soal.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        $writer->save("php://output");
        exit;
    }

    /**
     * Import soal dari Excel
     */
    public function import(Request $request, Exam $exam)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 1; $i < count($sheet); $i++) {
            $row = $sheet[$i];
            $questionText = $row[0] ?? '';
            $point = $row[1] ?? 1;
            $options = array_slice($row, 2, 5);
            $correctAnswer = $row[7] ?? 'A';

            if (empty($questionText)) continue;

            $question = ExamQuestion::create([
                'exam_id'       => $exam->id,
                'question_text' => $questionText,
                'point'         => $point,
                'question_type' => 'multiple_choice',
            ]);

            foreach ($options as $index => $optionText) {
                ExamQuestionOption::create([
                    'exam_question_id' => $question->id,
                    'option_label'     => chr(65 + $index),
                    'option_text'      => $optionText,
                    'is_correct'       => chr(65 + $index) === $correctAnswer,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Soal berhasil diimport!');
    }
}
