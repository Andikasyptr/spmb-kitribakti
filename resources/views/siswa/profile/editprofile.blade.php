@extends('layouts.app')
@section('title', 'Edit Profil Siswa')
@include('components.sidebar-siswa')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Edit Profil Siswa</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.siswa.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $siswa->nama ?? auth()->user()->name) }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $siswa->email ?? auth()->user()->email) }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $siswa->nik ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">No KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk', $siswa->no_kk ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">TTL</label>
                <input type="text" name="ttl" value="{{ old('ttl', $siswa->ttl ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $siswa->tahun_masuk ?? '') }}" class="w-full mt-1 p-2 border rounded">

                @php
                    $tahunAwal = 2025; // Tahun ajaran awal
                    $jumlahTahun = 10; // Jumlah tahun ajaran ke depan
                @endphp

            <div>
                <label class="block">Tahun Ajaran</label>
                <select name="tahun_ajaran" class="w-full border rounded p-2">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @for ($i = 0; $i < $jumlahTahun; $i++)
                        @php
                            $tahun = $tahunAwal + $i;
                            $label = $tahun . '/' . ($tahun + 1);
                        @endphp
                        <option value="{{ $label }}" {{ old('tahun_ajaran', $siswa->tahun_ajaran ?? '') == $label ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endfor
                </select>
            </div>

                {{-- <label class="block mt-4 text-sm font-medium">Kelas</label>
                <select name="kelas_id" class="w-full mt-1 p-2 border rounded">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ (old('kelas_id', $siswa->kelas_id ?? '') == $kelas->id) ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select> --}}
                <div>
                    <label for="kode_kelas" class="block mb-1 font-medium text-gray-700">Kode Kelas</label>
                    <select name="kode_kelas" id="kode_kelas" class="w-full border rounded p-2">
                        <option value="">-- Pilih Kode Kelas --</option>
                        <option value="1" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '2' ? 'selected' : '' }}>2</option>
                    </select>
                </div>

               <label for="jurusan" class="block text-sm font-medium">Jurusan</label>
                <select name="jurusan" id="jurusan" class="w-full mt-1 p-2 border rounded">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->nama_jurusan }}"
                            {{ (old('jurusan', $siswa->jurusan ?? '') == $jurusan->nama_jurusan) ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>


                <label class="block mt-4 text-sm font-medium">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Alamat</label>
                <textarea name="alamat" rows="2" class="w-full mt-1 p-2 border rounded">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>

                <label class="block mt-4 text-sm font-medium">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp ?? '') }}" class="w-full mt-1 p-2 border rounded">
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-2">Data Orang Tua</h3>

                <label class="block text-sm font-medium">Nama Ayah</label>
                <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">NIK Ayah</label>
                <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $siswa->nik_ayah ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Pendidikan Ayah</label>
                <input type="text" name="pendidikan_ayah" value="{{ old('pendidikan_ayah', $siswa->pendidikan_ayah ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Pekerjaan Ayah</label>
                <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Penghasilan Ayah</label>
                <input type="text" name="penghasilan_ayah" value="{{ old('penghasilan_ayah', $siswa->penghasilan_ayah ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Nama Ibu</label>
                <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">NIK Ibu</label>
                <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $siswa->nik_ibu ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Pendidikan Ibu</label>
                <input type="text" name="pendidikan_ibu" value="{{ old('pendidikan_ibu', $siswa->pendidikan_ibu ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Pekerjaan Ibu</label>
                <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Penghasilan Ibu</label>
                <input type="text" name="penghasilan_ibu" value="{{ old('penghasilan_ibu', $siswa->penghasilan_ibu ?? '') }}" class="w-full mt-1 p-2 border rounded">

                <label class="block mt-4 text-sm font-medium">Alamat Orang Tua</label>
                <textarea name="alamat_orang_tua" rows="2" class="w-full mt-1 p-2 border rounded">{{ old('alamat_orang_tua', $siswa->alamat_orang_tua ?? '') }}</textarea>
            </div>
        </div>

        <div class="mt-6 border-t pt-4">
            <h3 class="text-lg font-semibold mb-2">Upload Dokumen (opsional)</h3>

            @foreach(['file_skl' => 'SKL', 'file_ijazah' => 'Ijazah', 'file_ktp_orang_tua' => 'KTP Orang Tua', 'file_kk' => 'Kartu Keluarga', 'file_foto' => 'Pas Foto'] as $name => $label)
                <div class="mb-4">
                    <label class="block text-sm font-medium">{{ $label }}</label>
                    <input type="file" name="{{ $name }}" class="mt-1 p-1 border rounded w-full">
                    @if ($siswa && $siswa->$name)
                        <p class="text-sm mt-1">
                            File sekarang: 
                            <a href="{{ asset('storage/' . $siswa->$name) }}" class="text-blue-600 underline" target="_blank">Lihat</a>
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('profile.siswa') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Perubahan</button>
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
