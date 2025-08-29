@extends('layouts.app')
@section('title', 'Soal Ujian - smkhijaumuda')
@include('components.sidebar-guru')

@section('content')
<div class="p-4 sm:p-6 bg-white rounded-lg shadow max-w-7xl mx-auto">

    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <h1 class="text-xl sm:text-3xl font-bold text-gray-800">Soal Ujian: {{ $exam->title }}</h1>

       <!-- Buttons responsive -->
            <div class="flex flex-col sm:flex-row sm:flex-wrap sm:justify-end gap-2 w-full mt-2 sm:mt-0">
                <!-- Import Soal -->
                <form action="{{ route('guru.questions.import', $exam->id) }}" method="POST" enctype="multipart/form-data" class="w-full sm:w-auto">
                    @csrf
                    <input type="file" name="file" accept=".xlsx,.xls" required class="hidden" id="importFileInput">
                    <button type="button" onclick="document.getElementById('importFileInput').click()"
                            class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition duration-200">
                        Import Soal
                    </button>
                </form>
            
                <!-- Download Template -->
                <a href="{{ route('guru.questions.template', $exam->id) }}" 
                   class="w-full sm:w-auto bg-blue-500 hover:bg-blue-900 text-white px-4 py-2 rounded transition duration-200 text-center">
                    Download Template
                </a>
            
                <!-- Edit Soal -->
                <a href="{{ route('guru.questions.editAll', [$exam->id, $questions->first()->id ?? 0]) }}" 
                   class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded whitespace-nowrap transition duration-200 text-center">
                    Edit Soal
                </a>
            </div>

    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-4">{{ session('success') }}</div>
    @endif
    
    <!-- Spinner halaman full-screen -->
    <div id="pageSpinner" class="fixed inset-0 bg-white bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="w-12 h-12 border-4 border-red-500 border-t-transparent rounded-full animate-spin"></div>
    </div>


    <!-- Daftar Soal -->
    @if($questions->isEmpty())
        <p class="text-gray-500">Belum ada soal yang dibuat.</p>
    @else
        <ol class="pl-0 space-y-4">
            @foreach($questions as $index => $question)
                <li class="flex flex-col sm:flex-row sm:items-start sm:gap-4">

                    <!-- Konten soal -->
                    <div class="flex-1 p-4 border rounded-lg bg-gray-50 shadow-sm hover:shadow-md transition duration-200">
                        
                        <!-- Pertanyaan -->
                      <p class="font-semibold text-gray-800 mb-2">
                            <span class="font-bold mr-2">{{ $index + 1 }}.</span>
                            {{ $question->question_text }}
                            <span class="text-sm text-gray-500">({{ $question->point }} poin)</span>
                        </p>


                        <!-- Gambar soal -->
                        @if($question->image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $question->image_path) }}" 
                                     alt="Gambar Soal" 
                                     class="rounded shadow"
                                     style="max-width: 120px; width: auto; height: auto;">
                            </div>
                        @endif

                        <!-- Opsi jawaban -->
                        @if($question->options->isNotEmpty())
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                @foreach($question->options as $option)
                                    <li class="{{ $option->is_correct ? 'text-green-600 font-bold' : '' }}">
                                        {{ $option->option_label }}. {{ $option->option_text }}
                                        @if($option->image_path)
                                            <div class="mt-1">
                                                <img src="{{ asset('storage/' . $option->image_path) }}" 
                                                     alt="Gambar Opsi" 
                                                     class="rounded shadow"
                                                     style="max-width: 100px; width: auto; height: auto;">
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    @endif
</div>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    @include('components.sidebar-guru')
</div>
<div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const importFileInput = document.getElementById('importFileInput');
    const importSpinner = document.getElementById('importSpinner');

    if(importFileInput){
        importFileInput.addEventListener('change', function() {
            if(this.files.length > 0){
                if(importSpinner) importSpinner.classList.remove('hidden');
                setTimeout(() => this.form.submit(), 50);
            }
        });
    }

    // Mobile sidebar toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');

    function toggleSidebar() {
        if(mobileSidebar) mobileSidebar.classList.toggle('-translate-x-full');
        if(sidebarBackdrop) sidebarBackdrop.classList.toggle('hidden');
    }

    if(mobileMenuToggle) mobileMenuToggle.addEventListener('click', toggleSidebar);
    if(sidebarBackdrop) sidebarBackdrop.addEventListener('click', toggleSidebar);
});
</script>
@endpush

