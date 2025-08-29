<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\StudentAnswer;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;
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
                     ->where('start_time', '<=', $now)   // sudah mulai
                     ->where('end_time', '>=', $now)     // belum berakhir
                     ->orderBy('start_time', 'asc')
                     ->paginate(10);
    
        return view('siswa.e-learning.ujian', compact('exams'));
    }


    public function show($id)
    {
        $exam = Exam::with(['questions.options'])->findOrFail($id);

        // cek apakah siswa sudah mengerjakan
        $alreadyDone = StudentAnswer::where('student_id', Auth::id())
                                    ->where('exam_id', $id)
                                    ->exists();

        if ($alreadyDone) {
            return redirect()->route('siswa.ujian.index')
                             ->with('error', 'Anda sudah mengerjakan ujian ini.');
        }

        // pastikan hanya siswa kelas yang sesuai yang bisa mengakses
        $userKelas = Auth::user()->siswa->kelas->nama_kelas ?? null;
        if ($exam->kelas !== $userKelas) {
            return redirect()->route('siswa.ujian.index')
                             ->with('error', 'Ujian ini tidak tersedia untuk kelas Anda.');
        }

        return view('siswa.e-learning.detail-ujian', compact('exam'));
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

    // Jika AJAX request → kembalikan JSON redirect ke index
    if ($request->ajax()) {
        return response()->json([
            'redirect' => route('siswa.ujian.index')
        ]);
    }

    // Kalau submit manual → langsung redirect ke index
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
