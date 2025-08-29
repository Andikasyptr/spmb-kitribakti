@extends('layouts.app')
@section('title', 'Hasil Ujian - smkhijaumuda')
@include('components.sidebar-siswa')

@section('content')
<div class="p-4 sm:p-6 text-center flex flex-col items-center">
    <h1 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800">
        📊 Hasil Ujian: {{ $exam->title }}
    </h1>

    <!-- Card nilai -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 w-full max-w-md">
        <p class="text-base sm:text-lg text-gray-700 mb-2">Nilai Kamu</p>
        <p class="text-2xl sm:text-3xl font-bold text-green-600">
            {{ $score }} / {{ $maxScore }}
        </p>
    </div>

    <!-- Tombol kembali -->
    <div class="mt-6 w-full max-w-md">
        <a href="{{ route('siswa.ujian.index') }}" 
           class="block text-center bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg transition text-sm sm:text-base">
            ⬅️ Kembali ke Daftar Ujian
        </a>
    </div>
</div>
@endsection


@push('scripts')
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
