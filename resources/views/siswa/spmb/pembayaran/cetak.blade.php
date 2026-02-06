@extends('layouts.app')
@section('title', 'Cetak Bukti Pembayaran')
@include('components.sidebar-siswa')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 border border-gray-200">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Bukti Pembayaran Pendaftaran</h1>
                <p class="text-gray-600">SPMB - SMK KITRI BAKTI</p>
            </div>
            <img src="{{ asset('images/logokitri.png') }}" alt="Logo Sekolah" class="h-12 w-12">
        </div>

        <hr class="mb-6">

        {{-- Detail Pembayaran --}}
        <div class="space-y-3 text-gray-700">
            <p><strong>Nama Lengkap:</strong> {{ $pembayaran->nama }}</p>
            <p><strong>NISN:</strong> {{ $pembayaran->nisn }}</p>
            <p>
                <strong>Nominal Pembayaran:</strong> 
                <span class="font-semibold text-gray-900">
                    Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }},-
                </span>
            </p>
            <p><strong>Tanggal Upload:</strong> {{ $pembayaran->created_at->format('d M Y - H:i') }}</p>
            <p><strong>Status Pembayaran:</strong>
                <span class="px-2 py-1 rounded text-sm 
                    {{ $pembayaran->status === 'Sudah Bayar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $pembayaran->status }}
                </span>
            </p>
        </div>

        <!-- {{-- Bukti File Pembayaran --}}
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">📄 Bukti Pembayaran:</h2>
            @if(Str::endsWith($pembayaran->bukti_pembayaran, ['.jpg', '.jpeg', '.png']))
                <img src="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" 
                     alt="Bukti Pembayaran" 
                     class="rounded-lg border w-full max-w-md">
            @else
                <a href="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline">
                    Lihat file PDF
                </a>
            @endif
        </div> -->

        <div class="footer mt-8 text-center">
        <p class="text-gray-500" ><i>Dicetak otomatis dari sistem SPMB - SMK KITRI BAKTI pada {{ now()->format('d M Y H:i') }}</i></p>
    </div>

        {{-- Tombol Aksi --}}
        <div class="mt-8 flex justify-between items-center">
            <a href="{{ route('siswa.pembayaran') }}" class="text-gray-600 hover:underline">
                ← Kembali ke Halaman Pembayaran
            </a>

            <div class="flex space-x-3">
                {{-- Tombol Cetak --}}
                <button onclick="window.print()" 
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    🖨️ Cetak
                </button>

                {{-- Tombol Unduh PDF --}}
                <a href="{{ route('siswa.pembayaran.cetak', $pembayaran->id) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    📥 Unduh PDF
                </a>
            </div>
        </div>
    </div>

    <br>
    <br>

     
</div>
@endsection
