@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Tambah Pegawai')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Tambah Data Pegawai</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block">Nama</label>
                <input type="text" name="nama" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block">No Induk Kepegawaian</label>
                <input type="text" name="nip" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Jabatan</label>
                <input type="text" name="jabatan" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">No HP</label>
                <input type="text" name="no_hp" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Alamat</label>
                <textarea name="alamat" class="w-full border rounded p-2" rows="2"></textarea>
            </div>
            <div>
                <label class="block">Tempat Tanggal Lahir</label>
                <input type="text" name="ttl" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Jenis Pegawai</label>
                <select name="jenis_pegawai" id="jenis_pegawai" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="guru">Guru</option>
                    <option value="tenaga_kependidikan">Tenaga Kependidikan</option>
                </select>
            </div>
        </div>

        {{-- Bagian Khusus Guru --}}
        <div id="form-guru" class="mt-6 hidden border-t pt-4">
            <h3 class="text-lg font-semibold mb-2">Data Khusus Guru</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>Jumlah Kelas Mengajar</label>
                    <input type="number" name="jumlah_kelas_mengajar" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Jumlah Hari Mengajar</label>
                    <input type="number" name="jumlah_hari_mengajar" class="w-full border rounded p-2">
                </div>
                <div>
                    <label>Jumlah Jam Mengajar</label>
                    <button type="button" onclick="document.getElementById('jamPerHariModal').classList.remove('hidden')" class="w-full bg-blue-500 text-white p-2 rounded">
                        Isi Jam Mengajar per Hari
                    </button>
                </div>
                <div>
                    <label>Wali Kelas?</label><br>
                    <input type="checkbox" name="wali_kelas" value="1"> Ya
                </div>
            </div>

            <div class="mt-4">
                <label class="block mb-1">Mata Pelajaran</label>
                <div id="mapel-container">
                    <input type="text" name="mata_pelajaran[]" class="w-full border rounded p-2 mb-2">
                </div>
                <button type="button" onclick="tambahMapel()" class="text-sm text-blue-500">+ Tambah Mapel</button>
            </div>
        </div>

        {{-- Upload --}}
        <div class="mt-4">
            <label>Pas Foto 3x4</label>
            <input type="file" name="foto" accept="image/*" class="w-full border rounded p-2">
            <small class="text-gray-500 text-sm">Format .jpg, .jpeg, atau .png maksimal 2MB.</small>
        </div>

        <div class="mt-6">
            <label>Upload File SK (bisa lebih dari satu)</label>
            <input type="file" name="sks[]" multiple class="w-full border rounded p-2">
        </div>

        <div class="mt-4">
            <label>Upload Sertifikat (bisa lebih dari satu)</label>
            <input type="file" name="sertifikats[]" multiple class="w-full border rounded p-2">
        </div>

        {{-- Hidden input jumlah_jam dan jam per hari --}}
        <input type="hidden" name="jumlah_jam" id="jumlah_jam">
        <input type="hidden" name="senin" id="input-senin">
        <input type="hidden" name="selasa" id="input-selasa">
        <input type="hidden" name="rabu" id="input-rabu">
        <input type="hidden" name="kamis" id="input-kamis">
        <input type="hidden" name="jumat" id="input-jumat">

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>

{{-- Modal: Jam per Hari --}}
<div id="jamPerHariModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
        <h2 class="text-lg font-semibold mb-4">Jam Mengajar per Hari</h2>
        <div class="grid grid-cols-2 gap-4">
            <div><label>Senin</label><input type="number" id="senin" class="w-full border rounded p-2" min="0"></div>
            <div><label>Selasa</label><input type="number" id="selasa" class="w-full border rounded p-2" min="0"></div>
            <div><label>Rabu</label><input type="number" id="rabu" class="w-full border rounded p-2" min="0"></div>
            <div><label>Kamis</label><input type="number" id="kamis" class="w-full border rounded p-2" min="0"></div>
            <div><label>Jumat</label><input type="number" id="jumat" class="w-full border rounded p-2" min="0"></div>
        </div>
        <div class="mt-4 flex justify-end space-x-2">
            <button type="button" onclick="simpanJam()" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <button type="button" onclick="document.getElementById('jamPerHariModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    document.getElementById('jenis_pegawai').addEventListener('change', function () {
        const formGuru = document.getElementById('form-guru');
        formGuru.classList.toggle('hidden', this.value !== 'guru');
    });

    function tambahMapel() {
        const container = document.getElementById('mapel-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'mata_pelajaran[]';
        input.className = 'w-full border rounded p-2 mb-2';
        container.appendChild(input);
    }

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
@endsection
