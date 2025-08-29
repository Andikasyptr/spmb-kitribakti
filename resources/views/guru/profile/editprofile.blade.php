@extends('layouts.app')

@section('title', 'Edit Profile Guru - Smkhijaumuda')
@include('components.sidebar-guru')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-semibold mb-6">lengkapi Profile</h2>

    <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Informasi tidak bisa diubah --}}
        <div class="grid grid-cols-2 gap-4 text-sm">
            {{-- Nama --}}
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                class="mt-1 block w-full border rounded p-2" required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                class="mt-1 block w-full border rounded p-2" required>
        </div>

            <div>
                <label class="block font-semibold">NIP</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->nip ?? '-' }}">
            </div>

            <div>
                <label class="block font-semibold">Jabatan</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->jabatan ?? '-' }}">
            </div>

            <div>
                <label class="block font-semibold">Tempat/Tgl Lahir</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->ttl ?? '-' }}" >
            </div>

            <div>
                <label class="block font-semibold">Tahun Masuk</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->tahun_masuk ?? '-' }}" >
            </div>

            <div>
                <label class="block font-semibold">Jenis Pegawai</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ ucfirst($pegawai->jenis_pegawai) }}">
            </div>

            <div>
                <label class="block font-semibold">No HP</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->no_hp ?? '-' }}" >
            </div>

            <div class="col-span-2">
                <label class="block font-semibold">Alamat</label>
                <textarea class="w-full border px-3 py-2 rounded bg-gray-100" readonly>{{ $pegawai->alamat ?? '-' }}</textarea>
            </div>
        </div>

        {{-- Data Khusus Guru --}}
        @if ($pegawai->jenis_pegawai === 'guru')
            <div class="mt-6 border-t pt-4">
                <h3 class="font-semibold text-lg mb-2">Data Guru</h3> 
                <span>informasi ini diatur admin</span>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label class="block font-semibold">Jumlah Kelas Mengajar</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->jumlah_kelas_mengajar ?? '-' }}" readonly>
                    </div>

                    <div>
                        <label class="block font-semibold">Hari Mengajar</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->guruDetail->jumlah_hari_mengajar ?? '-' }}" readonly>
                    </div>

                     <div>
                        <label class="block font-semibold">Jumlah Jam Mengajar</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->guruDetail->jumlah_jam ?? '-' }}" readonly>
                    </div>

                    <div>
                        <label class="block font-semibold">Wali Kelas</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="{{ $pegawai->wali_kelas ? 'Ya' : 'Tidak' }}" readonly>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block font-semibold mb-1">Mata Pelajaran</label>
                    <ul class="list-disc pl-5 text-sm text-gray-700">
                        @php
                            $mapelList = is_string($pegawai->mata_pelajaran)
                                ? explode(',', $pegawai->mata_pelajaran)
                                : (is_array($pegawai->mata_pelajaran) ? $pegawai->mata_pelajaran : []);
                        @endphp

                        @forelse ($mapelList as $mapel)
                            <li>{{ trim($mapel) }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif

        {{-- Upload Dokumen --}}
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold text-lg mb-2">Upload Dokumen</h3>

            
<div class="mt-6 border-t pt-4">
    <h3 class="font-semibold text-lg mb-2">Pas Foto 3x4</h3>

    @if ($pegawai->foto)
        <div class="pl-5 mb-3">
            <p class="text-sm text-gray-700 mb-1">Foto saat ini:</p>
            <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Pas Foto Pegawai" class="w-32 h-40 object-cover border rounded shadow">
        </div>
    @else
        <p class="pl-5 text-sm text-red-500 mb-2">Tidak ada pas foto saat ini.</p>
    @endif

    <div>
        <label for="foto" class="block text-sm font-medium text-gray-700">Ganti Pas Foto</label>
        <input type="file" name="foto" id="foto" class="mt-1 block w-full border rounded p-2">
        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Ukuran max 2MB. Rasio 3x4 disarankan.</p>
    </div>
</div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">File SK (PDF/JPG/PNG)</label>
                @if ($pegawai->sk_file)
                    <p class="text-sm mb-1">File saat ini: 
                        <a href="{{ asset('storage/' . $pegawai->sk_file) }}" target="_blank" class="text-blue-500 underline">
                            Lihat SK
                        </a>
                    </p>
                @endif
                <input type="file" name="sk_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
                @error('sk_file') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Sertifikat (PDF/JPG/PNG)</label>
                @if ($pegawai->sertifikat_file)
                    <p class="text-sm mb-1">File saat ini: 
                        <a href="{{ asset('storage/' . $pegawai->sertifikat_file) }}" target="_blank" class="text-blue-500 underline">
                            Lihat Sertifikat
                        </a>
                    </p>
                @endif
                <input type="file" name="sertifikat_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
                @error('sertifikat_file') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row items-center gap-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 text-sm w-full sm:w-auto text-center">
                Simpan Dokumen
            </button>
        <a href="{{ route('guru.settings') }}" class="text-sm text-blue-600 hover:underline w-full sm:w-auto text-center">&larr; Kembali</a>

        </div>
    </form>
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