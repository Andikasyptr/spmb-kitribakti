@extends('layouts.app')
@section('title', 'Soal Ujian - smkhijaumuda')
@php $noSidebar = true; @endphp

@section('content')
<div class="p-4 sm:p-6">

    <!-- Header Fixed -->
    <div class="fixed top-0 left-0 right-0 bg-white shadow-md z-50 p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">📝 {{ $exam->title }}</h1>
            <h2 class="text-lg sm:text-2xl font-bold text-gray-800"> Kelas {{ $exam->kelas }}</h2>

            <p class="text-gray-600 text-sm sm:text-base">{{ $exam->description }}</p>
        </div>
        <div class="text-base sm:text-xl font-semibold text-red-600 mt-2 sm:mt-0">
            Waktu Tersisa: <span id="timer"></span>
        </div>
    </div>
    <br>
    <br>
    <br>
    

    <!-- Konten Soal (full width, padding-top untuk header) -->
    <div class="pt-32 sm:pt-36">
        <form id="exam-form" action="{{ route('siswa.ujian.submit', $exam->id) }}" method="POST">
            @csrf
            @foreach($exam->questions as $index => $question)
                <div class="mb-6 p-4 bg-white shadow rounded-lg w-full">
                    <h2 class="font-semibold text-gray-800 mb-2">Soal {{ $index + 1 }}</h2>

                    @if($question->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $question->image_path) }}" 
                                 alt="Gambar Soal" 
                                 class="rounded shadow w-full sm:w-auto max-w-md mx-auto"
                                 style="height: auto;">
                        </div>
                    @endif

                    <p class="mb-2 text-gray-700">{{ $question->question_text }}</p>

                    @foreach($question->options as $opt)
                        <label class="flex items-start sm:items-center mb-2 cursor-pointer">
                            <input type="radio"
                                   name="answers[{{ $question->id }}]" 
                                   value="{{ $opt->id }}"
                                   class="mr-3 mt-1 sm:mt-0 h-4 w-4 text-blue-600"
                                   required>
                            <div class="flex-1">
                                <span class="text-gray-700">{{ $opt->option_label }}. {{ $opt->option_text }}</span>
                                @if($opt->image_path)
                                    <div class="mt-1">
                                        <img src="{{ asset('storage/' . $opt->image_path) }}" 
                                             alt="Gambar Opsi {{ $opt->option_label }}" 
                                             class="rounded shadow w-full sm:w-auto max-w-md"
                                             style="height: auto;">
                                    </div>
                                @endif
                            </div>
                        </label>
                    @endforeach

                </div>
            @endforeach

            <div class="mt-6 text-center sm:text-right">
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow transition w-full sm:w-auto">
                    ✅ Kirim Jawaban
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('exam-form');
    const examId = "{{ $exam->id }}";
    let isSubmitting = false;

    const duration = {{ $exam->duration }} * 60;
    let timeLeft = localStorage.getItem('exam_timer_' + examId) ? parseInt(localStorage.getItem('exam_timer_' + examId)) : duration;
    const timerEl = document.getElementById('timer');

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerEl.textContent = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
        localStorage.setItem('exam_timer_' + examId, timeLeft);
        if(timeLeft <= 0){
            clearInterval(timerInterval);
            if(!isSubmitting) submitExamAuto('Waktu Habis!', 'Jawaban Anda akan dikirim otomatis.');
        }
        timeLeft--;
    }

    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer();

    // restore jawaban
    const savedAnswers = JSON.parse(localStorage.getItem('exam_answers_' + examId) || '{}');
    Object.keys(savedAnswers).forEach(qId => {
        const input = document.querySelector(`input[name="answers[${qId}]"][value="${savedAnswers[qId]}"]`);
        if(input) input.checked = true;
    });

    // simpan jawaban ke localStorage
    form.querySelectorAll('input[type=radio]').forEach(input => {
        input.addEventListener('change', function() {
            const answers = JSON.parse(localStorage.getItem('exam_answers_' + examId) || '{}');
            const name = this.name.match(/\d+/)[0];
            answers[name] = this.value;
            localStorage.setItem('exam_answers_' + examId, JSON.stringify(answers));
        });
    });

    // fungsi submit otomatis (waktu habis / keluar tab)
    function submitExamAuto(title, text) {
        if(isSubmitting) return;
        isSubmitting = true;

        Swal.fire({
            title: title,
            text: text,
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: 'OK',
            didOpen: () => { Swal.showLoading(); }
        }).then(() => {
            localStorage.removeItem('exam_answers_' + examId);
            localStorage.removeItem('exam_timer_' + examId);
            form.submit();
        });
    }

    // tombol submit manual
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin kirim jawaban?',
            text: "Setelah dikirim, jawaban tidak bisa diubah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, kirim jawaban!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed){
                isSubmitting = true;
                localStorage.removeItem('exam_answers_' + examId);
                localStorage.removeItem('exam_timer_' + examId);
                form.submit();
            }
        });
    });

    // --- AUTOSUBMIT kalau user keluar halaman ---
    function autoSubmitOnLeave() {
        if(isSubmitting) return;
        isSubmitting = true;

        // Ambil jawaban tersimpan
        let answers = JSON.parse(localStorage.getItem('exam_answers_' + examId) || '{}');
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");

        Object.keys(answers).forEach(qId => {
            formData.append(`answers[${qId}]`, answers[qId]);
        });

        // Kirim jawaban ke server
        fetch("{{ route('siswa.ujian.submit', $exam->id) }}", {
            method: "POST",
            body: formData,
            credentials: 'same-origin'
        }).finally(() => {
            localStorage.removeItem('exam_answers_' + examId);
            localStorage.removeItem('exam_timer_' + examId);

            Swal.fire({
                title: 'Ujian Ditutup!',
                text: 'Aduhh.. kenapa beralih halaman sih, See you tomorrow! 👋😊.',
                icon: 'warning',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'klik disini'
            }).then(() => {
                window.location.href = "{{ route('siswa.ujian.index', $exam->id) }}";
            });
        });
    }

    // Hanya deteksi tab benar2 ditutup (bukan refresh)
    window.addEventListener("pagehide", function(event) {
        if (!event.persisted) {  
            // Kalau persisted = true → biasanya reload / bfcache
            autoSubmitOnLeave();
        }
    });
    
    // Deteksi kalau user tinggalkan tab (berpindah ke tab lain)
    document.addEventListener("visibilitychange", function () {
        if (document.visibilityState === "hidden") {
            autoSubmitOnLeave();
        }
    });

});
</script>
@endpush

