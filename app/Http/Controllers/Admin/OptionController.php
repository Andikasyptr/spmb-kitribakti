<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Question $question)
    {
        $options = $question->options()->latest()->get();
        return view('admin.e-learning.options.index', compact('question', 'options'));
    }

    public function create(Question $question)
    {
        return view('admin.e-learning.options.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $request->validate([
            'option_text' => 'required|string',
            'is_correct'  => 'nullable|boolean',
        ]);

        $question->options()->create([
            'option_text' => $request->option_text,
            'is_correct'  => $request->has('is_correct'),
        ]);

        return redirect()->route('admin.options.index', $question->id)->with('success', 'Pilihan jawaban berhasil dibuat.');
    }

    public function edit(Question $question, Option $option)
    {
        return view('admin.e-learning.options.edit', compact('question', 'option'));
    }

    public function update(Request $request, Question $question, Option $option)
    {
        $request->validate([
            'option_text' => 'required|string',
            'is_correct'  => 'nullable|boolean',
        ]);

        $option->update([
            'option_text' => $request->option_text,
            'is_correct'  => $request->has('is_correct'),
        ]);

        return redirect()->route('admin.options.index', $question->id)->with('success', 'Pilihan jawaban berhasil diperbarui.');
    }

    public function destroy(Question $question, Option $option)
    {
        $option->delete();
        return redirect()->route('admin.options.index', $question->id)->with('success', 'Pilihan jawaban berhasil dihapus.');
    }
}
