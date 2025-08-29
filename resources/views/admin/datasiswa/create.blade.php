@extends('layouts.app')
@section('title', 'Tambah Siswa')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Tambah Data Siswa</h2>
        <form action="{{ route('datasiswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block">Nama</label>
                    <input type="text" name="nama" class="w-full border rounded p-2" value="{{ old('nama') }}" required>
                </div>
                <div>
                    <label class="block">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-2" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label class="block">NISN</label>
                    <input type="text" name="nisn" class="w-full border rounded p-2" value="{{ old('nisn') }}">
                </div>
                <div>
                    <label class="block">NIK</label>
                    <input type="text" name="nik" class="w-full border rounded p-2" value="{{ old('nik') }}">
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border rounded p-2">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Agama --}}
                {{-- <div>
                    <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                    <select name="agama" id="agama" class="w-full border rounded p-2">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div> --}}

                {{-- <div>
                    <label class="block">No. KK</label>
                    <input type="text" name="no_kk" class="w-full border rounded p-2" value="{{ old('no_kk') }}">
                </div> --}}
                <div>
                    <label class="block">Tempat, Tanggal Lahir</label>
                    <input type="text" name="ttl" class="w-full border rounded p-2" value="{{ old('ttl') }}">
                </div>
                <div>
                    <label class="block">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" class="w-full border rounded p-2" value="{{ old('tahun_masuk') }}">
                </div>
                @php
    $tahunSekarang = date('Y');
    $tahunAwal = 2020;
    $tahunAkhir = $tahunSekarang + 1;
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
                    <label for="kelas" class="block">Kelas</label>
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
                <label for="kode_kelas" class="block mb-1 font-medium text-gray-700">Kode Kelas</label>
                <select name="kode_kelas" id="kode_kelas" class="w-full border rounded p-2">
                    <option value="">-- Pilih Kode Kelas --</option>
                    <option value="1" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('kode_kelas', $siswa->kode_kelas ?? '') == '2' ? 'selected' : '' }}>2</option>
                </select>
            </div>
                {{-- <div>
                    <label>NIS</label>
                    <input type="text" name="nis" class="w-full border rounded p-2" value="{{ old('nis') }}">
                </div> --}}
                {{-- <div>
                    <label>No Ijazah</label>
                    <input type="text" name="no_ijazah" class="w-full border rounded p-2" value="{{ old('no_ijazah') }}">
                </div> --}}
                {{-- <div>
                    <label>NIK Ayah</label>
                    <input type="text" name="nik_ayah" class="w-full border rounded p-2" value="{{ old('nik_ayah') }}">
                </div> --}}
                {{-- <div>
                    <label>Pendidikan Terakhir Ayah</label>
                    <input type="text" name="pendidikan_ayah" class="w-full border rounded p-2" value="{{ old('pendidikan_ayah') }}">
                </div> --}}
                {{-- <div>
                    <label>Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" class="w-full border rounded p-2" value="{{ old('pekerjaan_ayah') }}">
                </div> --}}
                {{-- <div>
                    <label>Penghasilan Ayah</label>
                    <input type="text" name="penghasilan_ayah" class="w-full border rounded p-2" value="{{ old('penghasilan_ayah') }}">
                </div>
                <div>
                    <label>NIK Ibu</label>
                    <input type="text" name="nik_ibu" class="w-full border rounded p-2" value="{{ old('nik_ibu') }}">
                </div>
                <div>
                    <label>Pendidikan Terakhir Ibu</label>
                    <input type="text" name="pendidikan_ibu" class="w-full border rounded p-2" value="{{ old('pendidikan_ibu') }}">
                </div>
                <div>
                    <label>Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" class="w-full border rounded p-2" value="{{ old('pekerjaan_ibu') }}">
                </div>
                <div>
                    <label>Penghasilan Ibu</label>
                    <input type="text" name="penghasilan_ibu" class="w-full border rounded p-2" value="{{ old('penghasilan_ibu') }}">
                </div> --}}

                <div>
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan" class="w-full border rounded p-2">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($jurusans as $id => $nama)
                            <option value="{{ $nama }}" {{ old('jurusan') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <div>
                    <label class="block">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" class="w-full border rounded p-2" value="{{ old('asal_sekolah') }}">
                </div> --}}
                {{-- <div class="md:col-span-2">
                    <label class="block">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat') }}</textarea>
                </div> --}}
                <div class="md:col-span-2">
                    <label class="block">Status</label>
                    <select name="status" class="w-full border rounded p-2">
                        <option value="">-- Pilih Status --</option>
                        <option value="siswa aktif" {{ old('status') == 'siswa aktif' ? 'selected' : '' }}>Siswa Aktif</option>
                        <option value="siswa pindahan" {{ old('status') == 'siswa pindahan' ? 'selected' : '' }}>Siswa Pindahan</option>
                        <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>

                {{-- <div>
                    <label class="block">No. HP</label>
                    <input type="text" name="no_hp" class="w-full border rounded p-2" value="{{ old('no_hp') }}">
                </div>
                <div>
                    <label class="block">Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="w-full border rounded p-2" value="{{ old('nama_ayah') }}">
                </div>
                <div>
                    <label class="block">Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="w-full border rounded p-2" value="{{ old('nama_ibu') }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block">Alamat Orang Tua</label>
                    <textarea name="alamat_orang_tua" class="w-full border rounded p-2">{{ old('alamat_orang_tua') }}</textarea>
                </div>
            </div> --}}

            {{-- Upload file --}}
            {{-- <div class="mb-4">
                <label class="block">File SKL</label>
                <input type="file" name="file_skl" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label class="block">File Ijazah</label>
                <input type="file" name="file_ijazah" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label class="block">File KTP Orang Tua</label>
                <input type="file" name="file_ktp_orang_tua" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label class="block">File Kartu Keluarga</label>
                <input type="file" name="file_kk" class="w-full border rounded p-2">
            </div> --}}
            <div class="mb-4">
                <label class="block">Foto</label>
                <input type="file" name="file_foto" class="w-full border rounded p-2">
            </div>

            <div class="flex gap-4 mt-6">
                <a href="{{ route('datasiswa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
