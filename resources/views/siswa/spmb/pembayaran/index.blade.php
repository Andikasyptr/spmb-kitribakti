@extends('layouts.app')
@section('title', 'Pembayaran Pendaftaran')
@include('components.sidebar-siswa')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">

        {{-- Icon Pembayaran --}}
        <div class="flex justify-center mb-6">
            <div class="bg-green-100 p-4 rounded-full shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2zm4 10h6" />
                </svg>
            </div>
        </div>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Selesaikan Administrasi Pembayaran</h1>
        <p class="text-gray-600 mb-6 text-center">
            <span class="text-red-500">Mohon pastikan anda telah melengkapi data diri pada menu Pendaftaran.</span> selanjutnya silahkan Upload bukti pembayaran pendaftaran Anda di bawah ini.
        </p>

        {{-- Informasi Rekening Pembayaran --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">💳 Informasi Rekening Pembayaran</h2>
            <ul class="text-gray-700 space-y-1">
                <li><strong>Bank:</strong> BRI (Bank Rakyat Indonesia)</li>
                <li><strong>Nomor Rekening:</strong> 084801053491539</li>
                <li><strong>Atas Nama:</strong> Muh. Yusron - (Kepala Sekolah Kitri Bakti)</li>
                <li><strong>Jumlah Pembayaran Gelombang 1:</strong> Rp 450.000,- (Biaya pendaftaran)</li>
                <li><strong>Jumlah Pembayaran Gelombang 2:</strong> Rp 500.000,- (Biaya pendaftaran)</li>
            </ul>
        </div>

        {{-- Panduan Pembayaran --}}
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-6">
            <h2 class="text-lg font-semibold text-green-800 mb-2">🧾 Panduan Pembayaran</h2>
            <ol class="list-decimal list-inside text-gray-700 space-y-1">
                <li>Transfer biaya pendaftaran ke rekening di atas melalui ATM, Mobile Banking, atau teller bank.</li>
                <li>Pastikan nama pengirim sesuai dengan nama calon siswa.</li>
                <li>Simpan bukti pembayaran (struk atau screenshot transfer).</li>
                <li>Unggah bukti pembayaran melalui form di bawah ini.</li>
                <li>Mohon cek secara berkala pada menu Riwayat pembayaran anda untuk menunggu status verifikasi pembayaran anda.</li>
                <li>Apabila status <span class="text-red-700">"Menunggu Verifikasi"</span> sudah berubah menjadi <span class="text-blue-700">"Sudah Bayar"</span>, selanjutnya simpan dengan cara Cetak atau Donwload Bukti Pembayaran anda</li>
            </ol>
        </div>

        {{-- Catatan Format File --}}
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
            <p><strong>Catatan:</strong> Pastikan bukti pembayaran dalam format <strong>JPG, PNG, atau PDF</strong> 
            dengan ukuran maksimal <strong>2 MB</strong>.</p>
        </div>

        {{-- Form Upload Bukti Pembayaran --}}
        <form action="{{ route('siswa.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Input Nama Lengkap --}}
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Lengkap
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', Auth::user()->name ?? '') }}"
                       class="w-full border rounded p-2 focus:ring focus:ring-green-200" placeholder="Masukkan nama lengkap Anda" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input NISN --}}
            <div class="mb-4">
                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">
                    NISN
                </label>
               <input type="text" name="nisn" id="nisn"
                    value="{{ old('nisn', $siswa->nisn ?? '') }}"
                    class="w-full border rounded p-2 bg-gray-100 text-gray-700"
                    readonly>
                @error('nisn')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nominal Pembayaran --}}
            <div class="mb-4">
                <label for="nominal" class="block text-sm font-medium text-gray-700 mb-1">
                    Nominal Pembayaran
                </label>
                <input type="number" name="nominal" id="nominal" step="1000"
                       value="{{ old('nominal', 450000) }}"
                       class="w-full border rounded p-2 focus:ring focus:ring-green-200" placeholder="Masukkan nominal pembayaran (contoh: 450000)" required>
                @error('nominal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload Bukti Pembayaran --}}
            <div class="mb-4">
                <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">
                    Unggah Bukti Pembayaran
                </label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                       class="w-full border rounded p-2 focus:ring focus:ring-green-200">
                @error('bukti_pembayaran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-wrap items-center justify-between mt-6">
                <div class="flex space-x-3">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Upload
                    </button>
                    <a href="{{ route('siswa.dashboard') }}" class="text-gray-600 hover:underline flex items-center">
                        Kembali ke Dashboard
                    </a>
                </div>

                {{-- Tombol Cetak Bukti Pembayaran --}}
                @if ($pembayaran ?? false)
                    <a href="{{ route('siswa.pembayaran.cetak', $pembayaran->id) }}" 
                       class="mt-4 inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2V9a2 2 0 012-2h16a2 2 0 012 2v7a2 2 0 01-2 2h-2m-4 0H10v4h4v-4z" />
                        </svg>
                        Cetak Bukti Pembayaran
                    </a>
                @else
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                        <strong>Perhatian!</strong> Anda belum melakukan pembayaran.  
                        Silakan unggah bukti pembayaran terlebih dahulu sebelum mencetak bukti.
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===== Toggle Sidebar =====
    const toggleSidebar = () => {
        document.getElementById('mobile-sidebar')?.classList.toggle('-translate-x-full');
        document.getElementById('sidebar-backdrop')?.classList.toggle('hidden');
    };
    document.getElementById('mobile-menu-toggle')?.addEventListener('click', toggleSidebar);
    document.getElementById('sidebar-backdrop')?.addEventListener('click', toggleSidebar);

    // ===== Blok Tombol Back Browser =====
    // Tambahkan beberapa state agar halaman "terkunci"
    history.pushState(null, null, location.href);
    history.pushState(null, null, location.href);
    history.pushState(null, null, location.href);

    // Ketika user klik tombol back
    window.addEventListener('popstate', function () {
        history.pushState(null, null, location.href); // kembalikan state
        Swal.fire({
            icon: "error",
            title: "Aksi Diblokir",
            text: "Tombol kembali dinonaktifkan selama pengisian formulir.",
            showConfirmButton: false,
            timer: 1500
        });
    });

    // Blok tombol back di keyboard (Alt + Left)
    document.addEventListener('keydown', function(e) {
        if (e.altKey && e.key === 'ArrowLeft') {
            e.preventDefault();
        }
    });

    // Opsional: blok refresh Ctrl+R / F5
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey && e.key.toLowerCase() === 'r') || e.key === 'F5') {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Aksi Diblokir",
                text: "Refresh halaman dinonaktifkan selama pengisian formulir.",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
});
</script>
@endpush

