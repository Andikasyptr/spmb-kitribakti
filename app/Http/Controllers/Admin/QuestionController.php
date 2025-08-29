<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        $questions = $exam->questions()->latest()->get();
        return view('admin.e-learning.questions.index', compact('exam', 'questions'));
    }

    public function create(Exam $exam)
    {
        return view('admin.e-learning.questions.create', compact('exam'));
    }

   public function store(Request $request, Exam $exam)
{
    $request->validate([
        'question_text'   => 'required|string',
        'point'           => 'required|integer|min:1',
        'options'         => 'required|array|size:5', // A, B, C, D, E
        'correct_answer'  => 'required|string|in:A,B,C,D,E',
    ]);

    // Simpan soal
    $question = $exam->questions()->create([
        'question_text' => $request->question_text,
        'point'         => $request->point,
        'question_type' => 'multiple_choice', // bisa default multiple choice
    ]);

    // Simpan pilihan jawaban
    foreach ($request->options as $key => $value) {
        $question->options()->create([
            'option_label' => $key, // 'A', 'B', 'C', 'D', 'E'
            'option_text'  => $value,
            'is_correct'   => ($key === $request->correct_answer),
        ]);
    }

    return redirect()
    ->route('questions.index', $exam->id)
    ->with('success', 'Soal berhasil dibuat.');

}


    public function edit(Exam $exam, Question $question)
    {
        return view('admin.e-learning.questions.edit', compact('exam', 'question'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'question_type'  => 'required|string|in:multiple_choice,essay',
        ]);

        $question->update($request->only(['question_text', 'question_type']));

        return redirect()->route('admin.questions.index', $exam->id)->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index', $exam->id)->with('success', 'Soal berhasil dihapus.');
    }
}
