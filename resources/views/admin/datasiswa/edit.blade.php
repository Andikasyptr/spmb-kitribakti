@extends('layouts.app')
@section('title', 'Edit Siswa')
@include('components.sidebar-admin')
@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Edit Data Siswa</h2>
        @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form action="{{ route('datasiswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block">Nama</label>
                    <input type="text" name="nama" class="w-full border rounded p-2" value="{{ old('nama', $siswa->nama) }}" required>
                </div>
                <div>
                    <label class="block">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-2" value="{{ old('email', $siswa->email) }}" required>
                </div>
                <div>
                    <label class="block">NISN</label>
                    <input type="text" name="nisn" class="w-full border rounded p-2" value="{{ old('nisn', $siswa->nisn) }}">
                </div>
                <div>
                    <label class="block">NIK</label>
                    <input type="text" name="nik" class="w-full border rounded p-2" value="{{ old('nik', $siswa->nik) }}">
                </div>
                {{-- Jenis Kelamin --}}
                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Agama --}}
                <div class="mb-4">
                    <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                    <select name="agama" id="agama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" {{ old('agama', $siswa->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama', $siswa->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama', $siswa->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama', $siswa->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama', $siswa->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama', $siswa->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>

                <div>
                    <label class="block">No. KK</label>
                    <input type="text" name="no_kk" class="w-full border rounded p-2" value="{{ old('no_kk', $siswa->no_kk) }}">
                </div>
                <div>
                    <label class="block">Tempat, Tanggal Lahir</label>
                    <input type="text" name="ttl" class="w-full border rounded p-2" value="{{ old('ttl', $siswa->ttl) }}">
                </div>
                <div>
                    <label class="block">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" class="w-full border rounded p-2" value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}">
                </div>
                @php
    $tahunSekarang = date('Y');
    $tahunAwal = 2020;
    $tahunAkhir = $tahunSekarang + 1;
@endphp

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


                <div>
                <label for="kelas" class="block mb-1 font-medium text-gray-700">Kelas</label>
                    <select name="kelas_id" class="w-full border rounded p-2">
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id', $siswa->kelas_id ?? '') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="kode_kelas" class="block mb-1 font-medium text-gray-700">Kode Kelas</label>
                    <select name="kode_kelas" id="kode_kelas" class="w-full border rounded p-2">
                        <option value="">-- Pilih Kode Kelas --</option>
                        <option value="1" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '2' ? 'selected' : '' }}>2</option>
                    </select>
                </div>
                <div>
                    <label>NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>No Ijazah</label>
                    <input type="text" name="no_ijazah" value="{{ old('no_ijazah', $siswa->no_ijazah) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>NIK Ayah</label>
                    <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $siswa->nik_ayah) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Pendidikan Terakhir Ayah</label>
                    <input type="text" name="pendidikan_ayah" value="{{ old('pendidikan_ayah', $siswa->pendidikan_ayah) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Penghasilan Ayah</label>
                    <input type="text" name="penghasilan_ayah" value="{{ old('penghasilan_ayah', $siswa->penghasilan_ayah) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>NIK Ibu</label>
                    <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $siswa->nik_ibu) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Pendidikan Terakhir Ibu</label>
                    <input type="text" name="pendidikan_ibu" value="{{ old('pendidikan_ibu', $siswa->pendidikan_ibu) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Penghasilan Ibu</label>
                    <input type="text" name="penghasilan_ibu" value="{{ old('penghasilan_ibu', $siswa->penghasilan_ibu) }}" class="w-full border rounded p-2">
                </div>

                <div>
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan" id="jurusan" class="w-full border rounded p-2">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($jurusans as $id => $nama)
                            <option value="{{ $nama }}" {{ old('jurusan', $siswa->jurusan ?? '') == $nama ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" class="w-full border rounded p-2" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>
                <div class="md:col-span-2">
    <label class="block">Status</label>
    <select name="status" class="w-full border rounded p-2">
        <option value="">-- Pilih Status --</option>
        <option value="siswa aktif" {{ old('status', $siswa->status) == 'siswa aktif' ? 'selected' : '' }}>Siswa Aktif</option>
        <option value="siswa pindahan" {{ old('status', $siswa->status) == 'siswa pindahan' ? 'selected' : '' }}>Siswa Pindahan</option>
        <option value="keluar" {{ old('status', $siswa->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
    </select>
</div>

                <div>
                    <label class="block">No. HP</label>
                    <input type="text" name="no_hp" class="w-full border rounded p-2" value="{{ old('no_hp', $siswa->no_hp) }}">
                </div>
                <div>
                    <label class="block">Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="w-full border rounded p-2" value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                </div>
                <div>
                    <label class="block">Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="w-full border rounded p-2" value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block">Alamat Orang Tua</label>
                    <textarea name="alamat_orang_tua" class="w-full border rounded p-2">{{ old('alamat_orang_tua', $siswa->alamat_orang_tua) }}</textarea>
                </div>
            </div>

            {{-- Upload file --}}
            <div class="mb-4">
                <label class="block">File SKL</label>
                <input type="file" name="file_skl" class="w-full border rounded p-2">
                @if($siswa->file_skl)
                    <a href="{{ asset('storage/' . $siswa->file_skl) }}" target="_blank" class="text-blue-500 underline">Lihat File SKL</a>
                @endif
            </div>
            <div class="mb-4">
                <label class="block">File Ijazah</label>
                <input type="file" name="file_ijazah" class="w-full border rounded p-2">
                @if($siswa->file_ijazah)
                    <a href="{{ asset('storage/' . $siswa->file_ijazah) }}" target="_blank" class="text-blue-500 underline">Lihat File Ijazah</a>
                @endif
            </div>
            <div class="mb-4">
                <label class="block">File KTP Orang Tua</label>
                <input type="file" name="file_ktp_orang_tua" class="w-full border rounded p-2">
                @if($siswa->file_ktp_orang_tua)
                    <a href="{{ asset('storage/' . $siswa->file_ktp_orang_tua) }}" target="_blank" class="text-blue-500 underline">Lihat File KTP</a>
                @endif
            </div>
            <div class="mb-4">
                <label class="block">File Kartu Keluarga</label>
                <input type="file" name="file_kk" class="w-full border rounded p-2">
                @if($siswa->file_kk)
                    <a href="{{ asset('storage/' . $siswa->file_kk) }}" target="_blank" class="text-blue-500 underline">Lihat File KK</a>
                @endif
            </div>
            <div class="mb-4">
                <label class="block">Foto</label>
                <input type="file" name="file_foto" class="w-full border rounded p-2">
                @if($siswa->file_foto)
                    <img src="{{ asset('storage/' . $siswa->file_foto) }}" alt="Foto" class="h-24 mt-2">
                @endif
            </div>
            <div class="flex gap-4 mt-6">
                <a href="{{ route('datasiswa.index') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Kembali
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update
                </button>
            </div>

        </form>
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