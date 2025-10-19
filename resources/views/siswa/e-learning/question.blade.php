@php $currentQuestion = $question; @endphp

@if($currentQuestion)
<form id="form-ujian">
    @csrf
    <input type="hidden" id="exam_id" value="{{ $exam->id }}">
    <input type="hidden" id="question_id" value="{{ $currentQuestion->id }}">

    <div class="mb-6">
        <h3 class="font-semibold text-gray-700 mb-2">
            Soal {{ $currentNumber }} dari {{ $total }}
        </h3>
        <p class="text-gray-800">{!! $currentQuestion->question_text !!}</p>
    </div>

    <div class="space-y-2">
        @foreach ($currentQuestion->options as $opt)
            @php
                $isChecked = isset($savedAnswers[$currentQuestion->id]) && $savedAnswers[$currentQuestion->id] == $opt->id;
            @endphp
            <label class="block border p-2 rounded-lg cursor-pointer hover:bg-blue-50">
                <input type="radio"
                       name="option_id"
                       value="{{ $opt->id }}"
                       class="mr-2"
                       @if($isChecked) checked @endif>
                {{ $opt->option_text }}
            </label>
        @endforeach
    </div>

    {{-- Tombol navigasi --}}
    <div class="flex justify-between items-center mt-6">
        @if($currentNumber > 1)
            <button type="button" class="prev-btn bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Sebelumnya</button>
        @endif
        @if($currentNumber < $total)
            <button type="button" class="next-btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Berikutnya</button>
        @else
            <form action="{{ route('siswa.ujian.submit', $exam->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Selesai</button>
            </form>
        @endif
    </div>
</form>

<script>
const examId = {{ $exam->id }};
let currentNumber = {{ $currentNumber }};
const totalQuestions = {{ $total }};

// Fungsi simpan jawaban via AJAX
function saveAnswer(questionId, optionId) {
    return fetch(`/siswa/ujian/${examId}/${questionId}/answer`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ option_id: optionId })
    }).then(res => res.json());
}

// Fungsi render soal baru
function renderQuestion(html, savedAnswers, newNumber) {
    document.getElementById('question-container').innerHTML = html;
    currentNumber = newNumber;

    // update warna tombol nomor soal
    document.querySelectorAll('.question-btn').forEach(btn => {
        const qNum = parseInt(btn.dataset.number);
        if(savedAnswers[qNum]) {
            btn.classList.add('bg-green-500','text-white');
            btn.classList.remove('bg-gray-300','text-gray-800');
        } else {
            btn.classList.remove('bg-green-500','text-white');
            btn.classList.add('bg-gray-300','text-gray-800');
        }
    });
}

// Ambil soal via AJAX (dengan simpan jawaban sebelumnya)
function loadQuestion(targetNumber) {
    const questionId = document.getElementById('question_id')?.value;
    const selectedOption = document.querySelector('input[name="option_id"]:checked')?.value;

    const payload = selectedOption ? { option_id: selectedOption } : {};

    fetch(`/siswa/ujian/${examId}/${questionId || 0}/answer`, {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
    }).then(() => {
        fetch(`/siswa/ujian/${examId}/question/${targetNumber}`)
        .then(res => res.json())
        .then(data => {
            renderQuestion(data.html, data.savedAnswers, targetNumber);
        });
    });
}

// Event listener tombol navigasi
document.addEventListener('click', function(e){
    if(e.target.matches('.prev-btn') && currentNumber > 1) {
        loadQuestion(currentNumber - 1);
    }
    if(e.target.matches('.next-btn') && currentNumber < totalQuestions) {
        loadQuestion(currentNumber + 1);
    }
    if(e.target.matches('.question-btn')) {
        loadQuestion(parseInt(e.target.dataset.number));
    }
});

// Simpan jawaban saat klik opsi
document.addEventListener('change', function(e){
    if(e.target.matches('input[name="option_id"]')) {
        const questionId = document.getElementById('question_id').value;
        saveAnswer(questionId, e.target.value).then(() => {
            // update tombol hijau langsung
            const btn = document.querySelector(`.question-btn[data-number="${currentNumber}"]`);
            if(btn) btn.classList.add('bg-green-500','text-white');
        });
    }
});
</script>
@endif
