@extends('layouts.app', ['noSidebar' => true])
@section('title', 'Ujian - ' . $exam->title)


@section('content')
<div class="flex justify-center py-8 bg-gray-100 min-h-screen">
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-md p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">{{ $exam->nama_ujian }}</h2>

        @php
            $currentQuestion = $questions[$number - 1];
        @endphp

        {{-- Timer Ujian --}}
<div class="flex justify-center mb-4">
    <div class="bg-blue-50 border border-blue-200 rounded-full px-4 py-2 text-red-700 font-semibold shadow-sm">
        ⏳ Sisa Waktu: <span id="countdown">--:--:--</span>
    </div>
</div>


        <form id="form-ujian">
            @csrf
            <input type="hidden" id="exam_id" value="{{ $exam->id }}">
            <input type="hidden" id="question_id" value="{{ $currentQuestion->id }}">

            {{-- Soal --}}
           <div class="mb-6">
                <h3 class="font-semibold text-gray-700 mb-2">
                    Soal {{ $number }} dari {{ $total }}
                </h3>

                {{-- Teks Soal --}}
                <p class="text-gray-800">{!! $currentQuestion->question_text !!}</p>

                {{-- Tampilkan gambar jika ada --}}
                @if($currentQuestion->image_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $currentQuestion->image_path) }}" 
                            class="max-w-full h-auto rounded-md border shadow-sm">
                    </div>
                @endif

                {{-- ✅ Tambahan: Tampilkan poin soal --}}
                <div class="mt-3">
                    <span class="inline-block px-3 py-1 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-full shadow-sm">
                        {{ $currentQuestion->point }} poin
                    </span>
                </div>
            </div>


           
            {{-- Pilihan Jawaban --}}
            <div class="space-y-2">
                @foreach ($currentQuestion->options as $opt)
                    @php
                        $isChecked = isset($savedAnswers[$currentQuestion->id]) && $savedAnswers[$currentQuestion->id] == $opt->id;
                    @endphp
                    <label class="flex items-center border p-3 rounded-lg cursor-pointer hover:bg-blue-50 transition space-x-3">
                        <input type="radio"
                            name="option_id"
                            value="{{ $opt->id }}"
                            data-question="{{ $currentQuestion->id }}"
                            data-exam="{{ $exam->id }}"
                            class="mr-2"
                            @if($isChecked) checked @endif>

                        {{-- Label dan Teks --}}
                        <span class="font-medium">{{ $opt->option_label }}. {{ $opt->option_text }}</span>

                        {{-- Gambar jawaban --}}
                        @if($opt->image_path)
                            <img src="{{ asset('storage/' . $opt->image_path) }}" 
                                class="rounded-md border shadow-sm"
                                style="max-width: 120px; max-height: 80px; object-fit: contain;">
                        @endif
                    </label>
                @endforeach
            </div>



            {{-- Indikator Loading --}}
            <div id="saving-status" class="mt-3 text-sm text-gray-600 hidden">
                💾 <span id="saving-text">Menyimpan jawaban...</span>
            </div>

            {{-- Navigasi --}}
            <div class="flex justify-between items-center mt-6">
                @php
                    $prevNumber = max($number - 1, 1);
                    $nextNumber = min($number + 1, $total);
                @endphp

                @if($number > 1)
                    <a href="{{ route('siswa.ujian.show', ['examId' => $exam->id, 'number' => $prevNumber]) }}"
                       class="nav-question bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition"
                       data-url="{{ route('siswa.ujian.show', ['examId' => $exam->id, 'number' => $prevNumber]) }}">
                        Sebelumnya
                    </a>
                @else
                    <span></span>
                @endif

                @if($number < $total)
                    <a href="{{ route('siswa.ujian.show', ['examId' => $exam->id, 'number' => $nextNumber]) }}"
                       class="nav-question bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition"
                       data-url="{{ route('siswa.ujian.show', ['examId' => $exam->id, 'number' => $nextNumber]) }}">
                        Berikutnya
                    </a>
                @else
                    <button type="button" id="finishExam"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                        Selesai
                    </button>
                @endif
            </div>

            {{-- Nomor Soal --}}
            <div class="mt-8 border-t pt-4">
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach ($questions as $index => $q)
                        @php $isAnswered = isset($savedAnswers[$q->id]); @endphp
                        <a href="{{ route('siswa.ujian.show', ['examId' => $exam->id, 'number' => $index + 1]) }}"
                           class="nav-question px-3 py-2 rounded-lg font-semibold
                           {{ $isAnswered ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-800' }}
                           hover:scale-105 transition"
                           data-question-id="{{ $q->id }}"
                           data-url="{{ route('siswa.ujian.show', ['examId' => $exam->id, 'number' => $index + 1]) }}">
                           {{ $index + 1 }}
                        </a>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ==============================
    // 🔹 CONFIG
    // ==============================
    const csrfToken = "{{ csrf_token() }}";
    const examId = "{{ $exam->id }}";
    const finishUrl = `{{ route('ujian.selesai', ['exam' => $exam->id]) }}`;
    const countdownEl = document.getElementById('countdown');

    // ==============================
    // 🔹 SIMPAN JAWABAN OTOMATIS
    // ==============================
    async function saveAnswer(questionId, optionId) {
        const statusEl = document.getElementById('saving-status');
        const textEl = document.getElementById('saving-text');
        statusEl.classList.remove('hidden');
        statusEl.classList.add('animate-pulse');
        textEl.textContent = 'Menyimpan jawaban...';

        try {
            const url = `{{ url('/siswa/ujian') }}/${examId}/${questionId}/answer`;
            const res = await fetch(url, {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ option_id: optionId, _token: csrfToken })
            });

            if (!res.ok) throw new Error(`HTTP error ${res.status}`);
            const data = await res.json();
            textEl.textContent = data.success ? '✅ Jawaban tersimpan' : '❌ Gagal menyimpan';
            if (data.success) setTimeout(() => statusEl.classList.add('hidden'), 800);

        } catch (err) {
            console.error(err);
            textEl.textContent = '⚠️ Koneksi error';
        }
    }

    document.querySelectorAll('input[name="option_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            saveAnswer(this.dataset.question, this.value);
        });
    });

    document.querySelectorAll('a.nav-question').forEach(a => {
        a.addEventListener('click', async function(e) {
            e.preventDefault();
            const checked = document.querySelector('input[name="option_id"]:checked');
            if (checked) await saveAnswer(checked.dataset.question, checked.value);
            window.location.href = this.dataset.url;
        });
    });

    // ==============================
    // 🔹 TOMBOL SELESAI
    // ==============================
    const finishBtn = document.getElementById("finishExam");
    if (finishBtn) {
        finishBtn.addEventListener("click", function () {
            Swal.fire({
                title: "Selesaikan Ujian?",
                text: "Pastikan semua jawaban sudah benar.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Selesai!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(finishUrl, {
                        method: "POST",
                        headers: { 
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({ _token: csrfToken, exam_id: examId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({ title: "Ujian Diselesaikan!", text: "Jawaban Anda telah tersimpan.", icon: "success" })
                            .then(() => window.location.href = "{{ route('siswa.ujian.index') }}");
                        } else {
                            Swal.fire("Gagal", data.message || "Kesalahan server.", "error");
                        }
                    })
                    .catch(() => Swal.fire("Error", "Terjadi kesalahan server.", "error"));
                }
            });
        });
    }

    // ==============================
    // 🔹 TIMER COUNTDOWN
    // ==============================
    const endTimeServer = new Date("{{ $exam->end_time }}").getTime();
    const startTimeServer = new Date("{{ $exam->start_time }}").getTime();
    const now = new Date().getTime();
    let endTime = localStorage.getItem(`exam_${examId}_end`);
    if (!endTime) { localStorage.setItem(`exam_${examId}_end`, endTimeServer); endTime = endTimeServer; }
    else { endTime = parseInt(endTime); }

    if (now < startTimeServer) {
        Swal.fire({
            title: "Ujian Belum Dimulai",
            text: "Ujian akan dimulai pada {{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}",
            icon: "info",
            confirmButtonText: "OK"
        }).then(() => window.location.href = "{{ route('siswa.ujian.index') }}");
    } else {
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                clearInterval(timer);
                countdownEl.textContent = "00:00:00";
                Swal.fire({ title: "Waktu Habis!", text: "Jawaban Anda akan disimpan otomatis.", icon: "warning", showConfirmButton: false, timer: 3000 });
                setTimeout(() => {
                    fetch(finishUrl, {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                        body: JSON.stringify({ _token: csrfToken, exam_id: examId })
                    }).then(() => {
                        localStorage.removeItem(`exam_${examId}_end`);
                        window.location.href = "{{ route('siswa.ujian.index') }}";
                    });
                }, 3500);
            } else {
                const h = Math.floor((distance / (1000*60*60)) % 24);
                const m = Math.floor((distance / (1000*60)) % 60);
                const s = Math.floor((distance / 1000) % 60);
                countdownEl.textContent = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
            }
        }, 1000);
    }

    // ==============================
    // 🔹 BLOK TOMBOL BACK
    // ==============================
    history.pushState(null, null, location.href);
    window.onpopstate = () => {
        history.pushState(null, null, location.href);
        Swal.fire({ icon:"error", title:"Aksi Diblokir", text:"Tombol kembali dinonaktifkan selama ujian.", showConfirmButton:false, timer:1500 });
    };

    // ==============================
    // 🔹 BLOK SCREENSHOT, PRINT, DEVTOOLS, KANAN, COPY
    // ==============================
    document.addEventListener("keydown", function (e) {
        if(e.key === "PrintScreen") { e.preventDefault(); navigator.clipboard.writeText(""); Swal.fire({ icon:"warning", title:"Tidak Diizinkan", text:"Screenshot dinonaktifkan selama ujian.", timer:1500, showConfirmButton:false }); }
        if(e.ctrlKey && e.key.toLowerCase() === 'p') { e.preventDefault(); Swal.fire({ icon:"warning", title:"Tidak Diizinkan", text:"Mencetak halaman tidak diperbolehkan!", timer:1500, showConfirmButton:false }); }
        if(e.key === "F12" || (e.ctrlKey && e.shiftKey && ['i','j','c'].includes(e.key.toLowerCase()))) { e.preventDefault(); Swal.fire({ icon:"error", title:"Diblokir", text:"Inspect element dinonaktifkan!", timer:1500, showConfirmButton:false }); }
    });

    document.addEventListener('contextmenu', e => e.preventDefault());
    document.addEventListener('copy', e => { e.preventDefault(); Swal.fire({ icon:"info", title:"Tindakan Diblokir", text:"Menyalin teks tidak diizinkan saat ujian.", timer:1200, showConfirmButton:false }); });

});
</script>

@endsection
