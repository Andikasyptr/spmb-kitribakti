@extends('layouts.app')
@include('components.sidebar-guru')
@section('title', 'Edit Soal Ujian - smkhijaumuda')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-2xl font-bold text-blue-600 mb-6">
        Edit Soal - {{ $exam->title }}
    </h2>

    <form id="exam-form" action="{{ route('guru.questions.updateAll', $exam->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Soal Lama --}}
        @foreach($questions as $index => $question)
        <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition p-6">
            <h3 class="font-semibold text-lg text-gray-700 mb-4 flex justify-between items-center">
                <span>Soal {{ $index + 1 }}</span>
                <button type="button" 
                        class="delete-question-btn text-red-600 hover:text-red-800 font-semibold text-sm">
                    Hapus
                </button>
            </h3>


            <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">

            {{-- Gambar Soal --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Gambar (opsional)</label>
                @if($question->image_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $question->image_path) }}" alt="Gambar Soal" class="w-32 rounded border object-cover">
                    </div>
                @endif
                <input type="file"
                       name="questions[{{ $index }}][image]"
                       class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg p-2
                              file:border-0 file:bg-blue-50 file:text-blue-700 file:px-3 file:py-1
                              file:rounded file:hover:bg-blue-100 file:cursor-pointer"
                       accept="image/*">
            </div>

            {{-- Pertanyaan --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Pertanyaan</label>
                <textarea name="questions[{{ $index }}][question_text]"
                          rows="3"
                          class="w-full border border-blue-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ $question->question_text }}</textarea>
            </div>

            {{-- Poin --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Poin</label>
                <input type="number"
                       name="questions[{{ $index }}][point]"
                       value="{{ $question->point }}"
                       class="w-full border border-blue-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Pilihan Jawaban --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">Pilihan Jawaban</label>
                <div class="space-y-2">
                    @foreach($question->options as $opt)
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <div class="flex items-center gap-2 flex-1">
                            <input type="radio"
                                   name="questions[{{ $index }}][correct_answer]"
                                   value="{{ $opt->option_label }}"
                                   {{ $opt->is_correct ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <input type="text"
                                   name="questions[{{ $index }}][options][{{ $opt->option_label }}]"
                                   value="{{ $opt->option_text }}"
                                   placeholder="Jawaban {{ $opt->option_label }}"
                                   class="flex-1 border border-blue-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        </div>
                
                        {{-- Gambar Opsi --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 gap-2 mt-2">
                            @if($opt->image_path)
                                <img src="{{ asset('storage/' . $opt->image_path) }}" 
                                     alt="Gambar {{ $opt->option_label }}" 
                                     class="w-20 h-20 sm:w-12 sm:h-12 rounded border object-cover mx-auto sm:mx-0">
                            @endif
                            <label class="flex items-center gap-2 justify-center sm:justify-start cursor-pointer text-blue-600 hover:text-blue-700 text-sm border border-blue-300 rounded px-2 py-1">
                                <i class="fas fa-camera text-base sm:text-sm"></i>
                                <span class="truncate">Pilih Gambar</span>
                                <input type="file"
                                       name="questions[{{ $index }}][options][{{ $opt->option_label }}][image]"
                                       class="hidden"
                                       accept="image/*">
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        {{-- Container soal baru --}}
        <div id="new-questions-container" class="space-y-4"></div>

      <div class="flex justify-end gap-4 mt-6">
    {{-- Button Tambah Soal --}}
    <button type="button" id="add-question-btn" 
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
        + Tambah soal
    </button>

    {{-- Tombol Batal --}}
    <a href="{{ route('guru.exam-questions.index', $exam->id) }}"
       class="px-6 py-2 bg-gray-400 hover:bg-yellow-500 text-white font-semibold rounded-lg shadow-md transition">
        ❌ Batal
    </a>

    {{-- Tombol Submit --}}
    <button type="submit"
            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition">
        💾 Simpan semua
    </button>
</div>



    </form>
</div>

{{-- Template soal baru (hidden) --}}
<div id="new-question-template" class="hidden bg-white border rounded-xl shadow-sm hover:shadow-md transition p-6 mb-4">
           <h3 class="font-semibold text-lg text-green-600 mb-4 flex justify-between items-center">
            <span>+ Soal Baru</span>
            <button type="button" class="delete-new-question-btn text-red-600 hover:text-red-800 font-semibold text-sm">
                Hapus
            </button>
        </h3>


    <div class="mb-4">
        <label class="block font-medium text-gray-700 mb-1">Pertanyaan</label>
        <textarea name="new_questions[__INDEX__][question_text]"
                  rows="3"
                  class="w-full border border-green-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none"></textarea>
    </div>

    <div class="mb-4">
        <label class="block font-medium text-gray-700 mb-1">Poin</label>
        <input type="number"
               name="new_questions[__INDEX__][point]"
               value="1"
               class="w-full border border-green-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
    </div>

    <div class="mb-4">
        <label class="block font-medium text-gray-700 mb-1">Gambar (opsional)</label>
        <label class="flex items-center gap-2 cursor-pointer text-green-700 hover:text-green-800 text-sm border border-green-300 rounded px-2 py-1">
            <i class="fas fa-camera"></i>
            Pilih Gambar
            <input type="file" name="new_questions[__INDEX__][image]" class="hidden" accept="image/*">
        </label>
    </div>

    <div>
        <label class="block font-medium text-gray-700 mb-2">Pilihan Jawaban</label>
        <div class="space-y-2">
            @foreach(['A','B','C','D','E'] as $label)
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 border p-2 rounded">
                <div class="flex items-center gap-2 flex-1">
                    <input type="radio"
                           name="new_questions[__INDEX__][correct_answer]"
                           value="{{ $label }}"
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                    <input type="text"
                           name="new_questions[__INDEX__][options][{{ $label }}]"
                           placeholder="Jawaban {{ $label }}"
                           class="flex-1 border border-green-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-2 mt-2 sm:mt-0 w-full sm:w-auto">
                    <label class="flex items-center gap-1 cursor-pointer text-green-700 hover:text-green-800 text-sm border border-green-300 rounded px-2 py-1">
                        <i class="fas fa-camera"></i>
                        Pilih Gambar
                        <input type="file" name="new_questions[__INDEX__][options][{{ $label }}][image]" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    function toggleSidebar() {
        mobileSidebar.classList.toggle('-translate-x-full');
        sidebarBackdrop.classList.toggle('hidden');
    }
    if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', toggleSidebar);
    if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', toggleSidebar);

    // Preview gambar sebelum upload
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(){
            const file = this.files[0];
            if(file){
                const previewImg = this.closest('div').querySelector('img');
                if(previewImg){
                    previewImg.src = URL.createObjectURL(file);
                }
            }
        });
    });

    // Tambah soal baru
    let questionIndex = 0;
    const addBtn = document.getElementById('add-question-btn');
    const container = document.getElementById('new-questions-container');
    const template = document.getElementById('new-question-template').innerHTML;

    addBtn.addEventListener('click', function() {
        let newQuestionHtml = template.replace(/__INDEX__/g, questionIndex);
        const div = document.createElement('div');
        div.innerHTML = newQuestionHtml;
        container.appendChild(div);
        questionIndex++;
    });

    // Hapus soal lama dengan input hidden
    document.querySelectorAll('.delete-question-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if(confirm('Yakin ingin menghapus soal ini?')) {
                const questionDiv = this.closest('.bg-white');
                const questionIdInput = questionDiv.querySelector('input[name^="questions"][name$="[id]"]');
                if(questionIdInput){
                    const deletedInput = document.createElement('input');
                    deletedInput.type = 'hidden';
                    deletedInput.name = 'deleted_questions[]';
                    deletedInput.value = questionIdInput.value;
                    document.getElementById('exam-form').appendChild(deletedInput);
                }
                questionDiv.remove();
            }
        });
    });

    // Hapus soal baru (event delegation)
    container.addEventListener('click', function(e) {
        if(e.target.classList.contains('delete-new-question-btn')){
            if(confirm('Yakin ingin menghapus soal ini?')){
                e.target.closest('.bg-white').remove();
            }
        }
    });
});
</script>

@endpush
