@extends('layouts.app')
@section('title', 'Dashboard Siswa - SMK Hijau Muda')

@include('components.sidebar-siswa')

@section('content')
{{-- Wrapper dashboard dikasih ID biar bisa diblur --}}
<div id="dashboard-content" class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Selamat Datang -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, Siswa!</h1>
            <p class="text-gray-600">Ini adalah dashboard Anda sebagai siswa. Gunakan menu di sebelah kiri untuk mengakses materi, absensi, nilai, dan informasi lainnya.</p>
        </div>

        <!-- Pengumuman Terbaru -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengumuman Terbaru</h2>
            <div class="space-y-4">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg shadow hover:shadow-md transition">
                    <h3 class="font-semibold text-blue-700">Pelaksanaan STS (Sumatif Tengah Semester)</h3>
                    <p class="text-gray-700 text-sm mt-1">Sumatif Tengah Semester (STS) Tahun Ajaran 2025/2026 akan dilaksanakan pada 22 September 2025. Pastikan semua materi dipelajari.</p>
                    <p class="text-gray-400 text-xs mt-1">12 Agustus 2025</p>
                    <a href="#" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Baca Selengkapnya</a>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg shadow hover:shadow-md transition">
                    <h3 class="font-semibold text-blue-700">Pengambilan Raport STS Tahun Ajaran 2025/2026</h3>
                    <p class="text-gray-700 text-sm mt-1">Pengambilan rapot akan diinformasikan langsung oleh wali kelas masing-masing.</p>
                    <p class="text-gray-400 text-xs mt-1">16 Agustus 2025</p>
                    <a href="#" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Baca Selengkapnya</a>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg shadow hover:shadow-md transition">
                    <h3 class="font-semibold text-blue-700">Kegiatan Belajar Mengajar</h3>
                    <p class="text-gray-700 text-sm mt-1">Kegiatan belajar mengajar terus berjalan sehabis pelaksanaan STS Tahun Ajaran 2025/2026.</p>
                    <p class="text-gray-400 text-xs mt-1">29 Agustus 2025</p>
                    <a href="#" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Baca Selengkapnya</a>
                </div>
            </div>
        </div>

        @include('components.footer')
    </div>
</div>

{{-- Modal Wajib Lengkapi Profil --}}
@if (!auth()->user()->siswa)
    <style>
        body {
            overflow: hidden; /* biar tidak bisa discroll */
        }
        #dashboard-content {
            filter: blur(6px);
            pointer-events: none; /* blok interaksi */
            user-select: none;
            transition: filter 0.3s ease;
        }
    </style>

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-transparent backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-600 max-w-lg p-6 relative z-50">
            <div class="flex items-center space-x-3">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Lengkapi Data Diri</h3>
            </div>
            <p class="mt-4 text-sm text-gray-600">
                Anda wajib melengkapi data diri terlebih dahulu untuk bisa mengakses dashboard siswa.
            </p>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('spmb.form') }}"
                   class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                    Lengkapi Profil
                </a>
            </div>
        </div>
    </div>
@endif
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
