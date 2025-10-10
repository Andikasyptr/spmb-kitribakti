<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\StudentAnswer;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // ✅ tambahkan ini
use Illuminate\Http\Request;

class UjianController extends Controller
{
   public function index()
{
    $user = Auth::user();
    
    // ambil kelas siswa
    $kelasSiswa = $user->siswa->kelas->nama_kelas ?? null;
    
    // ambil waktu sekarang
    $now = now();
    
    // ambil ujian sesuai kelas siswa dan jadwal aktif
    $exams = Exam::where('kelas', $kelasSiswa)
                 ->where('start_time', '<=', $now)
                 ->where('end_time', '>=', $now)
                 ->orderBy('start_time', 'asc')
                 ->paginate(10);

    // 🧩 Ambil nilai radius dari kolom exam_radius di tabel users
    $radius = $user->exam_radius ?? 100; // default ke 100 kalau null

    // kirim radius ke view ujian
    return view('siswa.e-learning.ujian', compact('exams', 'radius'));
}

   public function show($id)
{
    $exam = Exam::with(['questions.options'])->findOrFail($id);
    $user = Auth::user();

    // 🧩 Cek apakah siswa sudah mengerjakan ujian
    $alreadyDone = StudentAnswer::where('student_id', $user->id)
                                ->where('exam_id', $id)
                                ->exists();

    if ($alreadyDone) {
        return redirect()->route('siswa.ujian.index')
                         ->with('error', 'Anda sudah mengerjakan ujian ini.');
    }

    // 🧩 Pastikan hanya siswa dari kelas yang sesuai yang bisa mengakses ujian
    $userKelas = $user->siswa->kelas->nama_kelas ?? null;
    if ($exam->kelas !== $userKelas) {
        return redirect()->route('siswa.ujian.index')
                         ->with('error', 'Ujian ini tidak tersedia untuk kelas Anda.');
    }

    // 🧩 Ambil radius khusus siswa dari tabel users (jika ada)
    $userRadius = $user->exam_radius ?? null;

    // 🧩 Ambil radius default dari tabel settings
    $defaultRadius = DB::table('settings')
                        ->where('key', 'exam_radius')
                        ->value('value');

    // 🧩 Gunakan userRadius jika ada, kalau tidak pakai default, kalau dua-duanya null pakai 100
    $radius = $userRadius ?? $defaultRadius ?? 100;

    // ✅ Kirim ke view (digunakan di JavaScript atau map lokasi)
    return view('siswa.e-learning.detail-ujian', compact('exam', 'radius'));
}

    public function submit(Request $request, $id)
    {
        $exam = Exam::with(['questions.options'])->findOrFail($id);
        $answers = $request->input('answers', []);

        $score = 0;
        $maxScore = $exam->questions->sum('point');

        foreach ($exam->questions as $question) {
            $selectedOption = $answers[$question->id] ?? null;

            if ($selectedOption) {
                $option = \App\Models\ExamQuestionOption::find((int)$selectedOption);

                if ($option) {
                    $isCorrect = $option->is_correct;

                    if ($isCorrect) {
                        $score += $question->point ?? 1;
                    }

                    StudentAnswer::updateOrCreate(
                        [
                            'student_id'  => Auth::id(),
                            'exam_id'     => $exam->id,
                            'question_id' => $question->id,
                        ],
                        [
                            'option_id'   => $option->id,
                            'is_correct'  => $isCorrect,
                        ]
                    );
                }
            }
        }

        ExamResult::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'exam_id'    => $exam->id,
            ],
            [
                'score' => $score,
            ]
        );

        if ($request->ajax()) {
            return response()->json([
                'redirect' => route('siswa.ujian.index')
            ]);
        }

        return redirect()->route('siswa.ujian.index')
                         ->with('success', 'Jawaban berhasil disimpan.');
    }

    public function hasil($id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        $result = ExamResult::where('student_id', Auth::id())
                            ->where('exam_id', $id)
                            ->firstOrFail();

        $score = $result->score;
        $maxScore = $exam->questions->sum('point');

        return view('siswa.e-learning.hasil-ujian', compact('exam', 'score', 'maxScore'));
    }
}
