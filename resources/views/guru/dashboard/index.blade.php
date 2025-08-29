@extends('layouts.app')
@section('title', 'Dashboard guru - SMK Hijau Muda')

@include('components.sidebar-guru')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Selamat Datang -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ $guru->name }} </h1>
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
                    <p class="text-gray-700 text-sm mt-1">pengambilan rapot akan diinformasikan langsung oleh wali kelas masing-masing.</p>
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

        <!-- Informasi Pendaftaran SPMB -->
        <!--<div class="bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100 p-6 rounded-lg shadow-md mb-6">-->
        <!--    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pendaftaran SPMB SMK Hijau Muda</h2>-->

        <!--    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-700">-->
        <!--        <div class="bg-white p-4 rounded shadow hover:shadow-md transition">-->
        <!--            <h3 class="font-bold text-blue-600">Jalur Masuk</h3>-->
        <!--            <p>Reguler & Prestasi</p>-->
        <!--        </div>-->
        <!--        <div class="bg-white p-4 rounded shadow hover:shadow-md transition">-->
        <!--            <h3 class="font-bold text-blue-600">Waktu Pendaftaran</h3>-->
        <!--            <p>1 Mei – 31 Juli 2025</p>-->
        <!--        </div>-->
        <!--        <div class="bg-white p-4 rounded shadow hover:shadow-md transition">-->
        <!--            <h3 class="font-bold text-blue-600">Syarat Umum</h3>-->
        <!--            <p>Scan SKL, KTP Orang Tua, KK, dan Pas Foto</p>-->
        <!--        </div>-->
        <!--        <div class="bg-white p-4 rounded shadow hover:shadow-md transition">-->
        <!--            <h3 class="font-bold text-blue-600">Biaya</h3>-->
        <!--            <p>Gratis biaya pendaftaran</p>-->
        <!--        </div>-->
        <!--        <div class="bg-white p-4 rounded shadow hover:shadow-md transition">-->
        <!--            <h3 class="font-bold text-blue-600">Kontak</h3>-->
        <!--            <p>Whatsapp: 0812-3456-7890</p>-->
        <!--        </div>-->
        <!--        <div class="bg-white p-4 rounded shadow hover:shadow-md transition">-->
        <!--            <h3 class="font-bold text-blue-600">Alamat Sekolah</h3>-->
        <!--            <p>Jl. Pendidikan No.12, Karawang</p>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <!-- Menu Cepat -->
        <!--<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">-->
        <!--    <a href="#" class="bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center hover:shadow-md transition">-->
        <!--        <span class="font-semibold text-gray-800">E-Learning</span>-->
        <!--    </a>-->
        <!--    <a href="#" class="bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center hover:shadow-md transition">-->
        <!--        <span class="font-semibold text-gray-800">Absensi</span>-->
        <!--    </a>-->
        <!--    <a href="#" class="bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center hover:shadow-md transition">-->
        <!--        <span class="font-semibold text-gray-800">Nilai</span>-->
        <!--    </a>-->
        <!--    <a href="#" class="bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center hover:shadow-md transition">-->
        <!--        <span class="font-semibold text-gray-800">Materi & Tugas</span>-->
        <!--    </a>-->
        <!--</div>-->

        @include('components.footer')
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

