@extends('layouts.app')
@section('title', 'Formulir data diri siswa')
@include('components.sidebar-siswa')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Lengkapi Data Anda</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('spmb.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Data Siswa --}}
               <x-input label="Nama" name="nama" value="{{ old('nama', auth()->user()->name) }}" readonly />
                <x-input label="Email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" readonly />
                <!--<x-input -->
                <!--    label="NISN" -->
                <!--    name="nisn" -->
                <!--    value="{{ old('nisn') }}" -->
                <!--    maxlength="10" -->
                <!--    pattern="\d{10}" -->
                <!--    inputmode="numeric"-->
                <!--/>                -->
                <!--<x-input -->
                <!--    label="NIK" -->
                <!--    name="nik" -->
                <!--    value="{{ old('nik') }}" -->
                <!--    maxlength="16" -->
                <!--    pattern="\d{16}" -->
                <!--    inputmode="numeric" -->
                <!--/>-->

                {{-- Jenis Kelamin --}}
<div>
    <label for="jenis_kelamin" class="block font-medium text-sm">Jenis Kelamin</label>
    <select name="jenis_kelamin" class="w-full mt-1 p-2 border rounded">
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
    </select>
</div>

{{-- Agama --}}
<div>
    <label for="agama" class="block font-medium text-sm">Agama</label>
    <select name="agama" class="w-full mt-1 p-2 border rounded">
        <option value="">-- Pilih Agama --</option>
        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
    </select>
</div>

                {{-- <x-input 
                    label="No. KK" 
                    name="no_kk" 
                    value="{{ old('no_kk') }}" 
                    maxlength="16" 
                    pattern="\d{16}" 
                    inputmode="numeric" 
                
                /> --}}
                <!--<x-input label="Tempat, Tanggal Lahir" name="ttl" value="{{ old('ttl') }}" note="*contoh : Bekasi, 01 Juli 2001." />-->
                <!--<x-input label="Tahun Masuk di SMK Hijau Muda" name="tahun_masuk" type="number" value="{{ old('tahun_masuk') }}" />-->
                @php
    $tahunSekarang = date('Y');
    $tahunAwal = 2020;
    $tahunAkhir = $tahunSekarang + 1;
@endphp

@php
    $tahunAwal = 2025; // Tahun awal 2025
    $jumlahTahun = 10; // Jumlah opsi tahun ajaran
@endphp

<div>
    <label class="block">Tahun Ajaran</label>
    <select name="tahun_ajaran" class="w-full border rounded p-2">
        <option value="">-- Pilih Tahun Ajaran --</option>
        <option value="2025/2026" {{ old('tahun_ajaran', $siswa->tahun_ajaran ?? '') == '2025/2026' ? 'selected' : '' }}>
            2025/2026
        </option>
    </select>
</div>



                {{-- <x-input 
                    label="NIS" 
                    name="nis" 
                    value="{{ old('nis') }}" 
                    maxlength="10" 
                    pattern="\d{10}" 
                    inputmode="numeric" 
                    
                /> --}}
                {{-- <x-input label="No. Ijazah" name="no_ijazah" value="{{ old('no_ijazah') }}" note="*Jika belum memiliki No. Ijazah, silakan lewati bagian ini." /> --}}
                {{-- Kelas & Jurusan --}}
                <div>
                    <label for="kelas_id" class="block font-medium">Kelas</label>
                    <select name="kelas_id" class="w-full border rounded p-2">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                <label for="jurusan" class="block text-sm font-medium">Jurusan</label>
                <select name="jurusan" class="w-full mt-1 p-2 border rounded">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->nama_jurusan }}"
                            {{ old('jurusan', $siswa->jurusan ?? '') == $jurusan->nama_jurusan ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

                <div>
                    <label for="kode_kelas" class="block mb-1 font-medium text-gray-700">
                        Kode Kelas
                    </label>
                    <select name="kode_kelas" id="kode_kelas" class="w-full border rounded p-2">
                        <option value="">-- Pilih Kode Kelas --</option>
                        <option value="1" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '2' ? 'selected' : '' }}>2</option>
                    </select>
                    <span  class="text-sm text-red-500">*Sebagai penanda kelas dalam jurusan, misal: TKR 1, TKR 2 dan lewati saja jika hanya satu kelas seperti X TKR, X TKJ, XMP, dan X OK</span>
                </div>

                
                </select>
                <!--<x-input label="Asal Sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" />-->
                <!--<x-input label="Alamat" name="alamat" value="{{ old('alamat') }}" />-->
                <!--<x-input -->
                <!--    label="No. HP" -->
                <!--    name="no_hp" -->
                <!--    value="{{ old('no_hp') }}" -->
                <!--    maxlength="13" -->
                <!--    pattern="\d{10,13}" -->
                <!--    inputmode="numeric" -->
                    
                <!--/>-->

                {{-- Data Ayah --}}
                {{-- <x-input label="Nama Ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" />
                <x-input 
                    label="NIK Ayah" 
                    name="nik_ayah" 
                    value="{{ old('nik_ayah') }}" 
                    maxlength="16" 
                    pattern="\d{16}" 
                    inputmode="numeric" 
                    
                /> --}}
                {{-- <div>
                    <label for="pendidikan_ayah" class="block text-sm font-medium">Pendidikan Terakhir Ayah</label>
                    <select name="pendidikan_ayah" class="w-full mt-1 p-2 border rounded">
                        <option value="">-- Pilih Pendidikan --</option>
                        <option value="SLTA" {{ old('pendidikan_ayah') == 'SLTA' ? 'selected' : '' }}>SLTA</option>
                        <option value="D3" {{ old('pendidikan_ayah') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('pendidikan_ayah') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_ayah') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan_ayah') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
                <x-input label="Pekerjaan Ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" />
                <div>
                    <label for="penghasilan_ayah" class="block text-sm font-medium">Penghasilan Ayah</label>
                    <input type="text" name="penghasilan_ayah" value="{{ old('penghasilan_ayah') }}" class="w-full mt-1 p-2 border rounded">
                    <p class="text-sm text-gray-500 mt-1">Contoh: Rp. 5.000.000</p>
                </div> --}}

                {{-- Data Ibu --}}
                {{-- <x-input label="Nama Ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" />
                <x-input 
                    label="NIK Ibu" 
                    name="nik_ibu" 
                    value="{{ old('nik_ibu') }}" 
                    maxlength="16" 
                    pattern="\d{16}" 
                    inputmode="numeric" 
                    
                /> --}}
                {{-- <div>
                    <label for="pendidikan_ibu" class="block text-sm font-medium">Pendidikan Terakhir Ibu</label>
                    <select name="pendidikan_ibu" class="w-full mt-1 p-2 border rounded">
                        <option value="">-- Pilih Pendidikan --</option>
                        <option value="SLTA" {{ old('pendidikan_ibu') == 'SLTA' ? 'selected' : '' }}>SLTA</option>
                        <option value="D3" {{ old('pendidikan_ibu') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('pendidikan_ibu') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_ibu') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan_ibu') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
                <x-input label="Pekerjaan Ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" />
                <div>
                    <label for="penghasilan_ibu" class="block text-sm font-medium">Penghasilan Ibu</label>
                    <input type="text" name="penghasilan_ibu" value="{{ old('penghasilan_ibu') }}" class="w-full mt-1 p-2 border rounded">
                    <p class="text-sm text-gray-500 mt-1">Contoh: Rp. 3.500.000</p>
                </div>

                <x-input label="Alamat Orang Tua" name="alamat_orang_tua" value="{{ old('alamat_orang_tua') }}" /> --}}

                {{-- Upload Dokumen --}}
                <div class="md:col-span-2 border-t pt-4 mt-4">
                    <h3 class="font-semibold text-lg mb-2">Upload Dokumen</h3>

                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 text-sm rounded mb-4">
                        <strong>Catatan:</strong> Semua dokumen <span class="font-semibold">wajib discan</span> terlebih dahulu dan diunggah dalam format <span class="font-semibold">PDF, JPG, atau JPEG</span>.
                    </div>

                    {{-- <x-input label="File SKL" type="file" name="file_skl" />
                    <x-input label="File Ijazah" type="file" name="file_ijazah" note="Jika belum ada, silakan lewati." />
                    <x-input label="File KTP Orang Tua" type="file" name="file_ktp_orang_tua" />
                    <x-input label="File Kartu Keluarga" type="file" name="file_kk" /> --}}
                    <x-input label="Pas Foto 3x4" type="file" name="file_foto" />
                </div>

            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simpan
                </button>
                <a href="{{ route('siswa.dashboard') }}" class="ml-4 text-gray-600 hover:underline">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleSidebar = () => {
            document.getElementById('mobile-sidebar')?.classList.toggle('-translate-x-full');
            document.getElementById('sidebar-backdrop')?.classList.toggle('hidden');
        };

        document.getElementById('mobile-menu-toggle')?.addEventListener('click', toggleSidebar);
        document.getElementById('sidebar-backdrop')?.addEventListener('click', toggleSidebar);
    });
</script>
@endpush
