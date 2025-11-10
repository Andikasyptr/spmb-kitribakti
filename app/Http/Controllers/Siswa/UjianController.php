<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\StudentAnswer;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Setting;

class UjianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelasSiswa = $user->siswa->kelas->nama_kelas ?? null;
        $now = now();

        $exams = Exam::where('kelas', $kelasSiswa)
                     ->where('start_time', '<=', $now)
                     ->where('end_time', '>=', $now)
                     ->orderBy('start_time', 'asc')
                     ->paginate(10);

        $userRadius = $user->exam_radius ?? null;
        $defaultRadius = DB::table('settings')
                            ->where('key', 'exam_radius')
                            ->value('value');
        $radius = $userRadius ?? $defaultRadius ?? 100;

        return view('siswa.e-learning.ujian', compact('exams', 'radius'));
    }

    public function show(Request $request, $examId, $number = null)
    {
        if (!$number || $number < 1) {
            return redirect()->route('siswa.ujian.show', [
                'examId' => $examId,
                'number' => 1
            ]);
        }

        $exam = Exam::with(['questions' => function($q) {
            $q->with('options')->orderBy('id', 'asc');
        }])->findOrFail($examId);

        $questions = $exam->questions;
        $total = $questions->count();

        if ($number > $total) {
            return redirect()->route('siswa.ujian.show', [
                'examId' => $examId,
                'number' => $total
            ]);
        }

        $studentId = auth()->id();
        $savedAnswers = StudentAnswer::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->pluck('option_id', 'question_id')
            ->toArray();

        return view('siswa.e-learning.detail-ujian', [
            'exam' => $exam,
            'questions' => $questions,
            'number' => $number,
            'total' => $total,
            'savedAnswers' => $savedAnswers,
        ]);
    }

    public function saveAnswer(Request $request, $examId, $questionId)
{
    $data = $request->json()->all();
    $optionId = $data['option_id'] ?? null;

    if (!$optionId) {
        return response()->json(['success' => false, 'message' => 'option_id kosong'], 400);
    }

    $studentId = auth()->id();

    // ✅ Simpan ke session sementara
    $sessionKey = 'exam_answers_' . $examId;
    $answers = session()->get($sessionKey, []);
    $answers[$questionId] = $optionId;
    session()->put($sessionKey, $answers);

    // ✅ (Opsional) Simpan langsung ke DB juga agar aman
    StudentAnswer::updateOrCreate(
        [
            'student_id' => $studentId,
            'exam_id' => $examId,
            'question_id' => $questionId
        ],
        [
            'option_id' => $optionId
        ]
    );

    return response()->json(['success' => true, 'message' => 'Jawaban tersimpan']);
}


    public function storeAnswer(Request $request, $examId, $questionId)
    {
        $user = Auth::user();
        $request->validate([
            'option_id' => 'required|integer',
        ]);

        $tempKey = "exam_temp_answers_{$examId}";
        $tempAnswers = $request->session()->get($tempKey, []);
        $tempAnswers[$questionId] = $request->option_id;
        $request->session()->put($tempKey, $tempAnswers);

        StudentAnswer::updateOrCreate(
            [
                'student_id' => $user->id,
                'exam_id' => $examId,
                'question_id' => $questionId,
            ],
            [
                'option_id' => $request->option_id,
            ]
        );

        $nextPage = $request->get('next_page');
        if ($nextPage) {
            return redirect()->route('siswa.ujian.show', ['examId' => $examId, 'number' => $nextPage]);
        }

        return back()->with('success', 'Jawaban disimpan.');
    }

    // ✅ FIXED: submit() sekarang tidak wajib ada parameter kedua
    public function submit(Request $request, $id = null)
    {
        $examId = $id ?? $request->input('exam_id');
        if (!$examId) {
            return back()->with('error', 'ID ujian tidak ditemukan.');
        }

        $exam = Exam::with(['questions.options'])->findOrFail($examId);
        $studentId = Auth::id();

        $answers = StudentAnswer::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->get();

        $score = 0;
        $maxScore = $exam->questions->sum('point');

        foreach ($answers as $answer) {
            $option = \App\Models\ExamQuestionOption::find($answer->option_id);
            if ($option && $option->is_correct) {
                $score += $answer->question->point ?? 1;
                $answer->is_correct = true;
                $answer->save();
            }
        }

        ExamResult::updateOrCreate(
            ['student_id' => $studentId, 'exam_id' => $exam->id],
            ['score' => $score]
        );

        DB::table('student_exams')->updateOrInsert(
            ['student_id' => $studentId, 'exam_id' => $exam->id],
            ['status' => 'selesai', 'updated_at' => now()]
        );

        return redirect()->route('siswa.ujian.index')->with('success', 'Ujian telah diselesaikan.');
    }

    public function saveTempAnswer(Request $request)
    {
        $questionId = $request->question_id;
        $optionId = $request->option_id;

        $answers = session('exam_answers', []);
        $answers[$questionId] = $optionId;
        session(['exam_answers' => $answers]);

        return response()->json(['success' => true]);
    }

    public function submitExam(Request $request, $examId)
    {
        $user = Auth::user();
        $answers = session('exam_answers', []);

        foreach ($answers as $questionId => $optionId) {
            StudentAnswer::updateOrCreate(
                [
                    'student_id' => $user->id,
                    'exam_id' => $examId,
                    'question_id' => $questionId
                ],
                [
                    'option_id' => $optionId
                ]
            );
        }

        $score = $this->calculateExamScore($examId, $user->id);

        ExamResult::updateOrCreate(
            ['exam_id' => $examId, 'student_id' => $user->id],
            ['score' => $score]
        );

        session()->forget('exam_answers');

        return redirect()->route('siswa.ujian.index')->with('success', 'Ujian telah diselesaikan!');
    }

    private function calculateExamScore($examId, $studentId)
    {
        $total = DB::table('questions')->where('exam_id', $examId)->count();
        $correct = DB::table('student_answers')
            ->join('options', 'student_answers.option_id', '=', 'options.id')
            ->where([
                ['student_answers.exam_id', '=', $examId],
                ['student_answers.student_id', '=', $studentId],
                ['options.is_correct', '=', 1]
            ])->count();

        return $total > 0 ? round(($correct / $total) * 100, 2) : 0;
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
   public function selesaikanUjian(Request $request, $examId)
{
    $user = Auth::user();

    // Ambil jawaban sementara dari session
    $answers = session()->get('exam_answers_' . $examId, []);

    // Jika session kosong, ambil dari database
    if (empty($answers)) {
        $answers = StudentAnswer::where('exam_id', $examId)
            ->where('student_id', $user->id)
            ->pluck('option_id', 'question_id')
            ->toArray();
    }

    if (empty($answers)) {
    return response()->json([
        'success' => true,
        'message' => 'Ujian diselesaikan tanpa jawaban.'
    ]);
}


    DB::beginTransaction();
    try {
        // Simpan jawaban ke tabel student_answers
        foreach ($answers as $questionId => $optionId) {
            StudentAnswer::updateOrCreate(
                [
                    'student_id' => $user->id,
                    'exam_id' => $examId,
                    'question_id' => $questionId,
                ],
                ['option_id' => $optionId]
            );
        }

        // ✅ Ambil data ujian beserta pertanyaan & opsi
        $exam = Exam::with(['questions.options'])->findOrFail($examId);
        $studentAnswers = StudentAnswer::where('student_id', $user->id)
            ->where('exam_id', $examId)
            ->get();

        // ✅ Hitung total poin benar
        $totalScore = 0;

        foreach ($studentAnswers as $answer) {
            $option = \App\Models\ExamQuestionOption::find($answer->option_id);

            if ($option && $option->is_correct) {
                // ✅ Ambil poin dari tabel exam_questions
                $question = \App\Models\ExamQuestion::find($answer->question_id);
                $totalScore += $question->point ?? 1;

                // Tandai jawaban benar
                $answer->is_correct = true;
                $answer->save();
            }
        }


        // ✅ Simpan total skor ke exam_results
        ExamResult::updateOrCreate(
            ['exam_id' => $examId, 'student_id' => $user->id],
            ['score' => $totalScore, 'status' => 'selesai']
        );

        // Hapus session jawaban sementara
        session()->forget('exam_answers_' . $examId);

        DB::commit();
        return response()->json(['success' => true, 'score' => $totalScore]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


}
