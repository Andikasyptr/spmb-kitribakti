@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Edit Soal Ujian - smkhijaumuda')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-2xl font-bold text-blue-600 mb-6">
        Edit Soal - {{ $exam->title }}
    </h2>

    <form id="exam-form" action="{{ route('exam-questions.updateAll', $exam->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Soal Lama --}}
        @foreach($questions as $index => $question)
            <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition p-6">
                <h3 class="font-semibold text-lg text-gray-700 mb-4">
                    Soal {{ $index + 1 }}
                </h3>

                <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">

                {{-- Gambar Soal --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Gambar (opsional)</label>
                    @if($question->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $question->image_path) }}" alt="Gambar Soal" class="w-32 rounded border">
                        </div>
                    @endif
                    <input type="file" name="questions[{{ $index }}][image]" class="w-full text-sm text-gray-700">
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
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 border p-2 rounded">
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
                                <div class="flex items-center gap-2">
                                    @if($opt->image_path)
                                        <img src="{{ asset('storage/' . $opt->image_path) }}" alt="Gambar {{ $opt->option_label }}" class="w-12 h-12 rounded border object-cover">
                                    @endif
                                    <input type="file" name="questions[{{ $index }}][options][{{ $opt->option_label }}][image]" class="text-sm text-gray-700">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Tambah Soal Baru --}}
        <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition p-6">
            <h3 class="font-semibold text-lg text-green-600 mb-4">
                ➕ Tambah Soal Baru
            </h3>

            @for($i = 0; $i < 1; $i++)
                {{-- Pertanyaan --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Pertanyaan</label>
                    <textarea name="new_questions[{{ $i }}][question_text]"
                              rows="3"
                              class="w-full border border-green-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none"></textarea>
                </div>

                {{-- Poin --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Poin</label>
                    <input type="number"
                           name="new_questions[{{ $i }}][point]"
                           value="1"
                           class="w-full border border-green-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                {{-- Gambar Soal Baru --}}
                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Gambar (opsional)</label>
                    <input type="file" name="new_questions[{{ $i }}][image]" class="w-full text-sm text-gray-700">
                </div>

                {{-- Pilihan Jawaban --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Pilihan Jawaban</label>
                    <div class="space-y-2">
                        @foreach(['A','B','C','D','E'] as $label)
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 border p-2 rounded">
                                <div class="flex items-center gap-2 flex-1">
                                    <input type="radio"
                                           name="new_questions[{{ $i }}][correct_answer]"
                                           value="{{ $label }}"
                                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <input type="text"
                                           name="new_questions[{{ $i }}][options][{{ $label }}]"
                                           placeholder="Jawaban {{ $label }}"
                                           class="flex-1 border border-green-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                </div>

                                {{-- Gambar Opsi Baru --}}
                                <div>
                                    <input type="file" name="new_questions[{{ $i }}][options][{{ $label }}][image]" class="text-sm text-gray-700">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endfor
        </div>

        {{-- Tombol Submit (Desktop) --}}
        <div class="hidden md:flex justify-end">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition">
                💾 Simpan Semua
            </button>
        </div>
    </form>
</div>

{{-- Floating Action Buttons (Mobile) --}}
<div class="fixed bottom-6 right-6 flex flex-col gap-3 md:hidden z-50">
    <!-- Tambah Soal -->
    <button type="button"
            onclick="window.scrollTo({top: document.body.scrollHeight, behavior:'smooth'})"
            class="w-14 h-14 flex items-center justify-center rounded-full bg-green-500 text-white shadow-lg hover:bg-green-600">
        <i class="fas fa-plus text-xl"></i>
    </button>
    
    <a href="{{ route('exam-questions.index', $exam->id) }}" 
       class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-500 text-white shadow-lg hover:bg-gray-600">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- Simpan -->
    <button type="button"
            onclick="document.getElementById('exam-form').submit();"
            class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-600 text-white shadow-lg hover:bg-blue-700">
        <i class="fas fa-save text-xl"></i>
    </button>
</div>
@endsection

@push('scripts')
<!-- Font Awesome -->
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
