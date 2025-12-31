@extends('layouts.app')
@section('title', 'Pendaftaran - SMK Kitri Bakti')

@include('components.sidebar-siswa')

@section('content')
{{-- Wrapper dashboard dikasih ID biar bisa diblur --}}
<div id="dashboard-content" class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Selamat Datang -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ $siswa->name }}</h1>
            <p class="text-gray-600">Ini adalah halaman Pendaftaran Anda sebagai Calon siswa. Gunakan menu di sebelah kiri untuk mengakses berbagai fitur lainnya.</p>
        </div>

        <!-- Status dan Kelengkapan Berkas -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Status Pendaftaran -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Status Pendaftaran</h2>
                @php
                    // Cek apakah ada record siswa dengan user_id saat ini
                    $isRegistered = \App\Models\Siswa::where('user_id', auth()->id())->exists();
                @endphp
                <p class="text-gray-700 font-medium">
                    @if ($isRegistered)
                        <span class="text-green-600">✅ Berhasil</span>
                    @else
                        <span class="text-red-600">❌ Belum Daftar</span>
                    @endif
                </p>
            </div>

            
        </div>
        
        <!-- Pengumuman Terbaru -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengumuman Terbaru</h2>
        <div class="space-y-4">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg shadow hover:shadow-md transition">
                <h3 class="font-semibold text-blue-700">Pelaksanaan Pendaftaran SPMB </h3>
                <p class="text-gray-700 text-sm mt-1">SPMB Gelombang 1 Tahun Ajaran 2026/2027 dilaksanakan pada 01 Desember 2025 - 01 Maret 2026</p>
                <p class="text-gray-400 text-xs mt-1">Biaya Pendaftaran - Rp. 450.000 (Free seragam olahraga)</p>
                <p class="text-blue-600 text-sm hover:underline mt-1 inline-block">Pastikan anda sudah mendaftarkan diri dan menyelesaikan administasi pembayaran sebelum tenggatnya</p>
            </div>
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg shadow hover:shadow-md transition">
                <h3 class="font-semibold text-blue-700">Pelaksanaan Pendaftaran SPMB </h3>
                <p class="text-gray-700 text-sm mt-1">SPMB Gelombang 1 Tahun Ajaran 2026/2027 dilaksanakan pada 01 Maret 2026 - 15 Juni 2026</p>
                <p class="text-gray-400 text-xs mt-1">Biaya Pendaftaran - Rp. 500.000 (Free seragam olahraga)</p>
                <p class="text-blue-600 text-sm hover:underline mt-1 inline-block">Pastikan anda sudah mendaftarkan diri dan menyelesaikan administasi pembayaran sebelum tenggatnya</p>
            </div>
            <!--<div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg shadow hover:shadow-md transition">-->
            <!--    <h3 class="font-semibold text-blue-700">Registrasi ulang peserta MPLS</h3>-->
            <!--    <p class="text-gray-700 text-sm mt-1">dilaksanakan juli 2026, pastikan anda membawa berkas fotocopy SKL, KK, KTP Orang Tua, dan pas Foto 3x4 Background Merah</p>-->
            <!--    <p class="text-gray-400 text-xs mt-1">Berkas diserahkan kepada Panitia SPMB SMK Kitri Bakti</p>-->
            <!--    <p class="text-blue-600 text-sm hover:underline mt-1 inline-block">Pastikan anda mengikuti berita informasi terbaru dari sekolah</p>-->
            <!--</div>-->
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
                <h3 class="text-lg font-semibold text-gray-900">Selamat Datang, {{ $siswa->name }} </h3>
            </div>
            <p class="mt-4 text-sm text-gray-600">
                Anda wajib melengkapi data diri terlebih dahulu untuk melanjutkan pendaftaran siswa baru
            </p>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('spmb.form') }}"
                   class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                    Lanjutkan
                </a>
            </div>
        </div>
    </div>
@endif

{{-- Modal Selesaikan Administrasi Pembayaran --}}
@if (session('show_payment_popup'))
    <div id="paymentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 text-center animate-fadeIn">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Selesaikan Administrasi Pembayaran</h2>
            <p class="text-gray-600 mb-6">
                Terima kasih telah melengkapi data diri Anda.  
                Silakan lanjut untuk menyelesaikan proses administrasi pembayaran agar pendaftaran Anda dapat diproses.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('siswa.pembayaran') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Lanjut ke Pembayaran
                </a>
                <button id="closeModal" 
                        class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>

    <script>
        // Tutup modal saat klik "Nanti Saja"
        document.addEventListener('DOMContentLoaded', function() {
            const closeBtn = document.getElementById('closeModal');
            closeBtn?.addEventListener('click', function() {
                document.getElementById('paymentModal').remove();
            });
        });
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
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
