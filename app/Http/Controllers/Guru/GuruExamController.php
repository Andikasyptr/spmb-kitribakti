<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Mapel; 
use App\Models\Kelas; 
use Illuminate\Support\Facades\Auth; 

class GuruExamController extends Controller
{
    // Tampilkan semua exam milik guru login
    public function index()
    {
        $exams = Exam::with('questions')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('guru.e-learning.exams.index', compact('exams'));
    }

    // Form buat exam baru
    public function create()
    {
        $mapels = Mapel::all();
        $kelas  = Kelas::all();
        return view('guru.e-learning.exams.create', compact('mapels', 'kelas'));
    }

    // Simpan exam baru
    public function store(Request $request)
    {
        $request->validate([
            'mapel_id'    => 'required|exists:mapels,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:1',
            'kelas'       => 'required|string',
            'start_time'  => 'nullable|date',
            'end_time'    => 'nullable|date|after:start_time',
        ]);

        Exam::create([
            'mapel_id'    => $request->mapel_id,
            'title'       => $request->title,
            'description' => $request->description,
            'duration'    => $request->duration,
            'kelas'       => $request->kelas,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'user_id'     => Auth::id(), // simpan siapa guru pembuat
            'total_questions' => 0,
        ]);

        return redirect()->route('guru.exams.index')
                         ->with('success', 'Ujian berhasil dibuat.');
    }

    // Form edit exam
    public function edit(Exam $exam)
    {
        $mapels = Mapel::all();
        $kelas  = Kelas::all();
        return view('guru.e-learning.exams.edit', compact('exam', 'mapels', 'kelas'));
    }

    // Update exam
    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:1',
            'kelas'       => 'required|string',
            'mapel_id'    => 'required|exists:mapels,id',
            'start_time'  => 'nullable|date',
            'end_time'    => 'nullable|date|after:start_time',
        ]);

        $exam->update([
            'mapel_id'    => $request->mapel_id,
            'title'       => $request->title,
            'description' => $request->description,
            'duration'    => $request->duration,
            'kelas'       => $request->kelas,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
        ]);

        return redirect()->route('guru.exams.index')
                         ->with('success', 'Ujian berhasil diperbarui.');
    }

    // Hapus ujian
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('guru.exams.index')
                         ->with('success', 'Ujian berhasil dihapus.');
    }
}
