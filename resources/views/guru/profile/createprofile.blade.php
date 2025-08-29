@extends('layouts.app')

@section('title', 'Lengkapi Profile Guru - Smkhijaumuda')
@include('components.sidebar-guru')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-semibold mb-6">Lengkapi Profile Guru</h2>

    <form action="{{ route('guru.profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informasi dasar --}}
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                    class="mt-1 block w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                    class="mt-1 block w-full border rounded p-2" required>
            </div>

            <div>
                <label for="nip" class="block font-semibold">NIP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label for="jabatan" class="block font-semibold">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label for="ttl" class="block font-semibold">Tempat/Tgl Lahir</label>
                <input type="text" name="ttl" id="ttl" value="{{ old('ttl') }}" class="w-full border px-3 py-2 rounded">
                <span>Contoh : Bekasi, 01 Juli 1987</span>
            </div>

            <div>
                <label for="tahun_masuk" class="block font-semibold">* Tahun Masuk</label>
                <input type="text" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk') }}" class="w-full border px-3 py-2 rounded">
                @error('tahun_masuk')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
            </div>

            <div>
                <label for="jenis_pegawai" class="block font-semibold">Jenis Pegawai</label>
                <select name="jenis_pegawai" id="jenis_pegawai" class="w-full border px-3 py-2 rounded" required>
                    <option value="guru" {{ old('jenis_pegawai') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="staff" {{ old('jenis_pegawai') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div>
                <label for="no_hp" class="block font-semibold">No HP</label>
                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="w-full border px-3 py-2 rounded">
            </div>

            <div class="col-span-2">
                <label for="alamat" class="block font-semibold">Alamat</label>
                <textarea name="alamat" id="alamat" class="w-full border px-3 py-2 rounded">{{ old('alamat') }}</textarea>
            </div>
        </div>

        {{-- Data Guru --}}
        <div class="mt-6 border-t pt-4" id="guru-data-section">
            <h3 class="font-semibold text-lg mb-2">Data Guru</h3>
            <span>data ini diatur admin</span>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <label for="jumlah_kelas_mengajar" class="block font-semibold">Jumlah Kelas Mengajar</label>
                    <input type="text" name="jumlah_kelas_mengajar" id="jumlah_kelas_mengajar" value="{{ old('jumlah_kelas_mengajar') }}" class="w-full border px-3 py-2 rounded" readonly >
                </div>

                <div>
                    <label for="jumlah_hari_mengajar" class="block font-semibold">Hari Mengajar</label>
                    <input type="text" name="jumlah_hari_mengajar" id="jumlah_hari_mengajar" value="{{ old('jumlah_hari_mengajar') }}" class="w-full border px-3 py-2 rounded" readonly>
                </div>

                <div>
                    <label for="jumlah_jam" class="block font-semibold">Jumlah Jam Mengajar</label>
                    <input type="text" name="jumlah_jam" id="jumlah_jam" value="{{ old('jumlah_jam') }}" class="w-full border px-3 py-2 rounded" readonly>
                </div>

                <div>
                    <label for="wali_kelas" class="block font-semibold">Wali Kelas</label>
                    <select name="wali_kelas" id="wali_kelas" class="w-full border px-3 py-2 rounded" disabled>
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label for="mata_pelajaran" class="block font-semibold">Mata Pelajaran (pisahkan dengan koma)</label>
                    <input type="text" name="mata_pelajaran" id="mata_pelajaran" value="{{ old('mata_pelajaran') }}" class="w-full border px-3 py-2 rounded" readonly>
                </div>
            </div>
        </div>

        {{-- Upload Dokumen --}}
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold text-lg mb-2">Upload Dokumen</h3>

            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Pas Foto 3x4</label>
                <input type="file" name="foto" id="foto" class="mt-1 block w-full border rounded p-2">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Ukuran max 2MB. Rasio 3x4 disarankan.</p>
            </div>

            <div class="mb-4">
                <label for="sk_file" class="block font-semibold mb-1">File SK (PDF/JPG/PNG)</label>
                <input type="file" name="sk_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="sertifikat_file" class="block font-semibold mb-1">Sertifikat (PDF/JPG/PNG)</label>
                <input type="file" name="sertifikat_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row items-center gap-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 text-sm w-full sm:w-auto text-center">
                Simpan Profile
            </button>
            <!--<a href="{{ route('guru.settings') }}" class="text-sm text-blue-600 hover:underline w-full sm:w-auto text-center">&larr; Kembali</a>-->
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
