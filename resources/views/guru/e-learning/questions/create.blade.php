@extends('layouts.app')
@section('title', 'Buat Soal Ujian - smkhijaumuda')
@include('components.sidebar-guru')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Kelola Soal untuk Ujian: {{ $exam->title }}</h1>
<form action="{{ route('guru.exam-questions.updateAll', $exam->id) }}" method="POST">
    @csrf
    @method('PUT')

        {{-- Soal Lama --}}
        @foreach(($questions ?? collect()) as $qIndex => $question)
        <div class="question-block border p-4 rounded-lg mb-4 bg-gray-50">
            <div>
                <label class="block font-semibold mb-1">Soal</label>
                <textarea name="questions[{{ $qIndex }}][question_text]" class="w-full border p-2 rounded" required>{{ $question->question_text }}</textarea>
            </div>

            <div class="mt-2">
                <label class="block font-semibold mb-1">Poin Soal</label>
                <input type="number" name="questions[{{ $qIndex }}][point]" class="w-full border p-2 rounded" value="{{ $question->point }}" min="1" required>
            </div>

            <div class="mt-3">
                <label class="block font-semibold mb-2">Pilihan Jawaban</label>
                @foreach (['A', 'B', 'C', 'D', 'E'] as $option)
                    @php
                        $optData = $question->options->firstWhere('option_label', $option);
                    @endphp
                    <div class="flex items-center gap-2 mb-2">
                        <input type="radio" name="questions[{{ $qIndex }}][correct_answer]" value="{{ $option }}" {{ $optData && $optData->is_correct ? 'checked' : '' }}>
                        <input type="text" name="questions[{{ $qIndex }}][options][{{ $option }}]" placeholder="Pilihan {{ $option }}" class="w-full border p-2 rounded" value="{{ $optData->option_text ?? '' }}">
                    </div>
                @endforeach
            </div>

            {{-- hidden id untuk update --}}
            <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">
        </div>
        @endforeach

        {{-- Soal Baru --}}
        <div id="questions-wrapper">
            <div class="question-block border p-4 rounded-lg mb-4 bg-gray-50">
                <div>
                    <label class="block font-semibold mb-1">Soal Baru</label>
                    <textarea name="new_questions[0][question_text]" class="w-full border p-2 rounded"></textarea>
                </div>

                <div class="mt-2">
                    <label class="block font-semibold mb-1">Poin Soal</label>
                    <input type="number" name="new_questions[0][point]" class="w-full border p-2 rounded" value="1" min="1">
                </div>

                <div class="mt-3">
                    <label class="block font-semibold mb-2">Pilihan Jawaban</label>
                    @foreach (['A', 'B', 'C', 'D', 'E'] as $option)
                        <div class="flex items-center gap-2 mb-2">
                            <input type="radio" name="new_questions[0][correct_answer]" value="{{ $option }}">
                            <input type="text" name="new_questions[0][options][{{ $option }}]" placeholder="Pilihan {{ $option }}" class="w-full border p-2 rounded">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Tombol Desktop --}}
        <div class="hidden sm:flex items-center gap-2 mt-4">
            <a href="{{ route('exam-questions.index', $exam->id) }}" 
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ← Kembali
            </a>
            <button type="button" id="add-question" class="bg-green-500 text-white px-4 py-2 rounded">
                + Tambah Soal Baru
            </button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Simpan Semua
            </button>
        </div>
</form>
</div>

{{-- Floating Action Buttons (Mobile Only) --}}
<div class="sm:hidden fixed bottom-16 right-6 flex flex-col gap-3 z-50">
    <a href="{{ route('guru.exam-questions.index', $exam->id) }}" 
       class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-500 text-white shadow-lg hover:bg-gray-600">
        <i class="fas fa-arrow-left"></i>
    </a>
    <button type="button" id="fab-add" 
       class="w-12 h-12 flex items-center justify-center rounded-full bg-green-500 text-white shadow-lg hover:bg-green-600">
        <i class="fas fa-plus"></i>
    </button>
    <button type="submit" form="form" 
       class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-500 text-white shadow-lg hover:bg-blue-600">
        <i class="fas fa-save"></i>
    </button>
</div>

<script>
    let questionIndex = 1;
    document.getElementById('add-question').addEventListener('click', addQuestion);
    document.getElementById('fab-add').addEventListener('click', addQuestion);

    function addQuestion() {
        let wrapper = document.getElementById('questions-wrapper');
        let firstQuestion = document.querySelector('#questions-wrapper .question-block');
        let newQuestion = firstQuestion.cloneNode(true);

        // reset nilai input
        newQuestion.querySelectorAll('textarea').forEach(el => el.value = '');
        newQuestion.querySelectorAll('input[type="number"]').forEach(el => el.value = 1);
        newQuestion.querySelectorAll('input[type="radio"]').forEach(el => el.checked = false);
        newQuestion.querySelectorAll('input[type="text"]').forEach(el => el.value = '');

        // update index name
        newQuestion.querySelectorAll('textarea, input').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${questionIndex}]`);
        });

        wrapper.appendChild(newQuestion);
        questionIndex++;
    }
</script>
@endsection

@push('scripts')
<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            mobileSidebar.classList.toggle('-translate-x-full');
            sidebarBackdrop.classList.toggle('hidden');
        }

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', toggleSidebar);
        }
    });
</script>
@endpush
