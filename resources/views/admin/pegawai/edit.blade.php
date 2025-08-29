@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Edit Pegawai')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Edit Data Pegawai</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Data Umum --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block">Nama</label>
                <input type="text" name="nama" class="w-full border rounded p-2"
                    value="{{ old('nama', $pegawai->nama) }}" required>
            </div>
            <div>
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2"
                    value="{{ old('email', $pegawai->email) }}" required>
            </div>
            <div>
                <label class="block">No Induk Kepegawaian</label>
                <input type="text" name="nip" class="w-full border rounded p-2"
                    value="{{ old('nip', $pegawai->nip) }}">
            </div>
            <div>
                <label class="block">Jabatan</label>
                <input type="text" name="jabatan" class="w-full border rounded p-2"
                    value="{{ old('jabatan', $pegawai->jabatan) }}">
            </div>
            <div>
                <label class="block">No HP</label>
                <input type="text" name="no_hp" class="w-full border rounded p-2"
                    value="{{ old('no_hp', $pegawai->no_hp) }}">
            </div>
            <div>
                <label class="block">Alamat</label>
                <textarea name="alamat" class="w-full border rounded p-2" rows="2">{{ old('alamat', $pegawai->alamat) }}</textarea>
            </div>
            <div>
                <label class="block">Tempat Tanggal Lahir</label>
                <input type="text" name="ttl" class="w-full border rounded p-2"
                    value="{{ old('ttl', $pegawai->ttl) }}">
            </div>
            <div>
                <label class="block">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" class="w-full border rounded p-2"
                    value="{{ old('tahun_masuk', $pegawai->tahun_masuk) }}">
            </div>
            <div>
                <label class="block">Jenis Pegawai</label>
                <select name="jenis_pegawai" id="jenis_pegawai" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="guru" {{ old('jenis_pegawai', $pegawai->jenis_pegawai) == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="tenaga_kependidikan" {{ old('jenis_pegawai', $pegawai->jenis_pegawai) == 'tenaga_kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                </select>
            </div>
        </div>

        {{-- Data Khusus Guru --}}
        <div id="form-guru" class="mt-6 border-t pt-4 {{ old('jenis_pegawai', $pegawai->jenis_pegawai) == 'guru' ? '' : 'hidden' }}">
            <h3 class="text-lg font-semibold mb-2">Data Khusus Guru</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>Jumlah Kelas Mengajar</label>
                    <input type="number" name="jumlah_kelas_mengajar" class="w-full border rounded p-2"
                        value="{{ old('jumlah_kelas_mengajar', optional($pegawai->guruDetail)->jumlah_kelas_mengajar) }}">
                </div>
                <div>
                    <label>Jumlah Hari Mengajar</label>
                    <input type="number" name="jumlah_hari_mengajar" class="w-full border rounded p-2"
                        value="{{ old('jumlah_hari_mengajar', optional($pegawai->guruDetail)->jumlah_hari_mengajar) }}">
                </div>
                <div>
                    <label>Input Jumlah Jam Guru</label>
                    <button type="button" onclick="document.getElementById('jamPerHariModal').classList.remove('hidden')" class="w-full bg-teal-800 text-white p-2 rounded">
                        klik disini
                    </button>
                </div>
                <div>
                    <label>Wali Kelas?</label><br>
                    <input type="checkbox" name="wali_kelas" value="1" {{ old('wali_kelas', optional($pegawai->guruDetail)->wali_kelas) ? 'checked' : '' }}> Ya
                </div>
            </div>

           {{-- Hidden input for jam --}}
            <input type="hidden" name="jumlah_jam" id="jumlah_jam" value="{{ old('jumlah_jam', $pegawai->jumlah_jam ?? 0) }}">
            <input type="hidden" name="senin" id="input-senin" value="{{ old('senin', $pegawai->senin ?? 0) }}">
            <input type="hidden" name="selasa" id="input-selasa" value="{{ old('selasa', $pegawai->selasa ?? 0) }}">
            <input type="hidden" name="rabu" id="input-rabu" value="{{ old('rabu', $pegawai->rabu ?? 0) }}">
            <input type="hidden" name="kamis" id="input-kamis" value="{{ old('kamis', $pegawai->kamis ?? 0) }}">
            <input type="hidden" name="jumat" id="input-jumat" value="{{ old('jumat', $pegawai->jumat ?? 0) }}">


            {{-- Input Mata Pelajaran --}}
            <div class="mt-4">
                <label class="block mb-1">Mata Pelajaran</label>
                <div id="mapel-container">
                    @php
                        $mapels = old('mata_pelajaran') ?? ($pegawai->mapels ? $pegawai->mapels->pluck('mata_pelajaran')->toArray() : []);
                    @endphp
                    @foreach ($mapels as $mapel)
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text" name="mata_pelajaran[]" value="{{ $mapel }}" class="w-full border rounded p-2">
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="tambahMapel()" class="text-sm text-blue-600 hover:underline mt-2">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Mapel
                </button>
            </div>
        </div>

        {{-- Pas Foto --}}
        <div class="mt-6 border-t pt-4">
            <label class="block font-semibold mb-2">Pas Foto 3x4</label>
            @if ($pegawai->foto)
                <img src="{{ asset('storage/' . $pegawai->foto) }}" class="w-32 h-40 object-cover rounded mb-2">
            @endif
            <input type="file" name="foto" class="w-full border rounded p-2">
        </div>

        {{-- File SK --}}
        <div class="mt-6">
            <label>File SK</label>
            <input type="file" name="sks[]" multiple class="w-full border rounded p-2">
        </div>

        {{-- Sertifikat --}}
        <div class="mt-4">
            <label>Sertifikat</label>
            <input type="file" name="sertifikats[]" multiple class="w-full border rounded p-2">
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('pegawai.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>

{{-- Modal Jam Mengajar --}}
<div id="jamPerHariModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Jam Mengajar per Hari</h2>
        <div class="grid grid-cols-2 gap-4">
            <div><label>Senin</label><input type="number" id="senin" class="w-full border rounded p-2"></div>
            <div><label>Selasa</label><input type="number" id="selasa" class="w-full border rounded p-2"></div>
            <div><label>Rabu</label><input type="number" id="rabu" class="w-full border rounded p-2"></div>
            <div><label>Kamis</label><input type="number" id="kamis" class="w-full border rounded p-2"></div>
            <div><label>Jumat</label><input type="number" id="jumat" class="w-full border rounded p-2"></div>
        </div>
        <div class="mt-4 flex justify-end space-x-2">
            <button type="button" onclick="simpanJam()" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <button type="button" onclick="document.getElementById('jamPerHariModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function tambahMapel() {
        const container = document.getElementById('mapel-container');
        const div = document.createElement('div');
        div.className = "flex items-center gap-2 mb-2";
        div.innerHTML = `<input type="text" name="mata_pelajaran[]" class="w-full border rounded p-2">
                         <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i class="fas fa-trash-alt"></i></button>`;
        container.appendChild(div);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('senin').value = document.getElementById('input-senin').value;
        document.getElementById('selasa').value = document.getElementById('input-selasa').value;
        document.getElementById('rabu').value = document.getElementById('input-rabu').value;
        document.getElementById('kamis').value = document.getElementById('input-kamis').value;
        document.getElementById('jumat').value = document.getElementById('input-jumat').value;
    });

    function simpanJam() {
        const hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        let total = 0;
        hari.forEach(h => {
            const val = parseInt(document.getElementById(h).value) || 0;
            document.getElementById('input-' + h).value = val;
            total += val;
        });
        document.getElementById('jumlah_jam').value = total;
        document.getElementById('jamPerHariModal').classList.add('hidden');
    }
</script>
@endpush
