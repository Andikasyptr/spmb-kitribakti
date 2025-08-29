<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class GuruOptionController extends Controller
{
    public function index(Question $question)
    {
        // Pastikan guru hanya bisa akses soal miliknya
        if ($question->exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $options = $question->options()->latest()->get();
        return view('guru.e-learning.options.index', compact('question', 'options'));
    }

    public function create(Question $question)
    {
        if ($question->exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('guru.e-learning.options.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        if ($question->exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'option_text' => 'required|string',
            'is_correct'  => 'nullable|boolean',
        ]);

        $question->options()->create([
            'option_text' => $request->option_text,
            'is_correct'  => $request->has('is_correct'),
        ]);

        return redirect()->route('guru.options.index', $question->id)
                         ->with('success', 'Pilihan jawaban berhasil dibuat.');
    }

    public function edit(Question $question, Option $option)
    {
        if ($question->exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('guru.e-learning.options.edit', compact('question', 'option'));
    }

    public function update(Request $request, Question $question, Option $option)
    {
        if ($question->exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'option_text' => 'required|string',
            'is_correct'  => 'nullable|boolean',
        ]);

        $option->update([
            'option_text' => $request->option_text,
            'is_correct'  => $request->has('is_correct'),
        ]);

        return redirect()->route('guru.options.index', $question->id)
                         ->with('success', 'Pilihan jawaban berhasil diperbarui.');
    }

    public function destroy(Question $question, Option $option)
    {
        if ($question->exam->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $option->delete();
        return redirect()->route('guru.options.index', $question->id)
                         ->with('success', 'Pilihan jawaban berhasil dihapus.');
    }
}
