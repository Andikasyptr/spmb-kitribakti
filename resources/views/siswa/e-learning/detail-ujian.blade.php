@extends('layouts.app', ['noSidebar' => true])
@section('title', 'Ujian - ' . $exam->title)

@section('content')
<div class="flex justify-center py-8 bg-gray-100 min-h-screen">
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-md p-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">{{ $exam->nama_ujian }}</h2>

        @php
            $currentQuestion = $questions[$number - 1];
        @endphp

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

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = "{{ csrf_token() }}";

    // Simpan jawaban otomatis saat memilih opsi
    async function saveAnswer(questionId, optionId, examId) {
        const statusEl = document.getElementById('saving-status');
        const textEl = document.getElementById('saving-text');
        statusEl.classList.remove('hidden');
        textEl.textContent = 'Menyimpan jawaban...';
        statusEl.classList.add('animate-pulse');

        try {
            const res = await fetch(`/siswa/ujian/${examId}/${questionId}/answer`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ option_id: optionId })
            });
            const data = await res.json();

            if (data.success) {
                textEl.textContent = '✅ Jawaban tersimpan';
                setTimeout(() => statusEl.classList.add('hidden'), 800);
            } else {
                textEl.textContent = '❌ Gagal menyimpan';
            }
        } catch (error) {
            textEl.textContent = '⚠️ Koneksi error';
        }
    }

    // Event untuk setiap opsi jawaban
    document.querySelectorAll('input[name="option_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            saveAnswer(this.dataset.question, this.value, this.dataset.exam);
        });
    });

    // Navigasi antar soal
    document.querySelectorAll('a.nav-question').forEach(a => {
        a.addEventListener('click', async function(e) {
            e.preventDefault();
            const checked = document.querySelector('input[name="option_id"]:checked');
            if (checked) {
                await saveAnswer(checked.dataset.question, checked.value, checked.dataset.exam);
            }
            window.location.href = this.dataset.url;
        });
    });

    // SweetAlert tombol selesai
    const finishBtn = document.getElementById("finishExam");
if (finishBtn) {
    finishBtn.addEventListener("click", function () {
        Swal.fire({
            title: "Selesaikan Ujian?",
            text: "Pastikan semua jawaban sudah benar. Setelah diselesaikan, ujian tidak dapat diulang.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Selesai!"
        }).then((result) => {
            if (result.isConfirmed) {
                const examId = "{{ $exam->id }}";

                // ✅ gunakan route() Laravel biar URL-nya valid dan aman
                fetch(`{{ route('ujian.selesai', ['exam' => $exam->id]) }}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    // ✅ sertakan _token dan exam_id agar Laravel mengenalinya
                    body: JSON.stringify({
                        _token: "{{ csrf_token() }}",
                        exam_id: examId
                    })
                })
                .then(async (res) => {
                    // Tangani error dari server
                    if (!res.ok) {
                        const errText = await res.text();
                        throw new Error(errText || "Server error");
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Ujian Diselesaikan!",
                            text: "Jawaban Anda telah tersimpan dan ujian dinyatakan selesai.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            // ✅ arahkan ke halaman daftar ujian
                            window.location.href = "{{ route('siswa.ujian.index') }}";
                        });
                    } else {
                        Swal.fire("Gagal", data.message || "Terjadi kesalahan saat menyimpan.", "error");
                    }
                })
                .catch((err) => {
                    console.error(err);
                    Swal.fire("Error", "Terjadi kesalahan server. Silakan coba lagi.", "error");
                });
            }
        });
    });
}


    // Cegah tombol back
    history.pushState(null, null, location.href);
    window.onpopstate = () => history.go(1);
});
</script>
@endsection
