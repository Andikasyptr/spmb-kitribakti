<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB; // ✅ Tambahkan ini

class ExamController extends Controller
{
    // Tampilkan semua ujian
    public function index()
    {
        $exams = Exam::with('questions')->latest()->get();
        return view('admin.e-learning.exams.index', compact('exams'));
    }

    // Form buat ujian
    public function create()
    {
        $mapels = Mapel::all();
        $kelas  = Kelas::all();
        return view('admin.e-learning.exams.create', compact('mapels', 'kelas'));
    }

    // Simpan ujian baru
    public function store(Request $request)
    {
        $request->validate([
            'mapel_id'    => 'required|exists:mapels,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:1',
            'kelas'       => 'required|string',
            'start_time'  => 'date',
            'end_time'    => 'date|after:start_time',
        ]);

        Exam::create([
            'mapel_id'    => $request->mapel_id,
            'title'       => $request->title,
            'description' => $request->description,
            'duration'    => $request->duration,
            'total_questions' => 0,
            'kelas'       => $request->kelas,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'Ujian berhasil dibuat.');
    }

    // Form edit ujian
    public function edit(Exam $exam)
    {
        $mapels = Mapel::all();
        $kelas  = Kelas::all();
        return view('admin.e-learning.exams.edit', compact('exam', 'mapels', 'kelas'));
    }

    // Update ujian
    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:1',
            'kelas'       => 'required|string',
            'mapel_id'    => 'required|exists:mapels,id',
            'start_time'  => 'date',
            'end_time'    => 'date|after:start_time',
        ]);

        $exam->update([
            'title'       => $request->title,
            'description' => $request->description,
            'duration'    => $request->duration,
            'kelas'       => $request->kelas,
            'mapel_id'    => $request->mapel_id,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    // Hapus ujian satuan
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Ujian berhasil dihapus.');
    }

    // ✅ Hapus semua ujian
    public function deleteAll()
    {
        DB::beginTransaction();
        try {
            DB::table('exams')->delete();
            DB::statement('ALTER TABLE exams AUTO_INCREMENT = 1');
            DB::commit();

            return redirect()->route('admin.exams.index')->with('success', 'Semua data ujian berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
