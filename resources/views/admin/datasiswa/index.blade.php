@extends('layouts.app')
@section('title', 'Data Siswa - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">

            <!-- Header & Tombol Aksi -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
                <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                    <!-- Tombol Tambah -->
                    <a href="{{ route('datasiswa.create') }}"
                        class="bg-blue-600 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow hover:bg-blue-700 transition-all">
                        ➕ Tambah
                    </a>

                    <!-- Tombol Download Template -->
                    <a href="{{ route('datasiswa.download-template') }}"
                        class="bg-green-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-700 transition-all">
                        📄 Template
                    </a>

                    <!-- Form Import -->
                    <form action="{{ route('datasiswa.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-2 items-center">
                        @csrf
                        <input type="file" name="file" accept=".xlsx,.xls" required
                            class="border rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-auto">
                        <button type="submit"
                            class="bg-indigo-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-indigo-700 transition-all">
                            ⬆️ Import
                        </button>
                    </form>

                    <!-- Tombol Hapus Semua -->
                    <form id="delete-all-form" action="{{ route('datasiswa.deleteAll') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="confirmDeleteAll()"
                            class="bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-red-700 transition-all">
                         Hapus Semua
                        </button>
                    </form>
                </div>
            </div>

             <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{!! session('error') !!}</div>
            @endif

            <!-- Tabel Data -->
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">NISN</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Kelas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Jurusan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">JK</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Agama</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($siswas as $index => $siswa)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3">{{ $siswas->firstItem() + $index }}</td>
                                <td class="px-6 py-3">{{ $siswa->nama }}</td>
                                <td class="px-6 py-3">{{ $siswa->nisn }}</td>
                                <td class="px-6 py-3">{{ $siswa->kelas->nama_kelas ?? 'Belum diatur' }}</td>
                                <td class="px-6 py-3">{{ $siswa->jurusan }}</td>
                                <td class="px-6 py-3">{{ $siswa->jenis_kelamin}}</td>
                                <td class="px-6 py-3">{{ $siswa->agama }}</td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('datasiswa.show', $siswa->id) }}" class="text-blue-600 hover:underline font-medium">
                                        Lihat
                                    </a>
                                    <form id="delete-siswa-form-{{ $siswa->id }}" action="{{ route('datasiswa.destroy', $siswa->id) }}" method="POST" class="inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteSiswa({{ $siswa->id }})" class="text-red-600 hover:underline font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-6 text-gray-500">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $siswas->withQueryString()->links() }}</div>
            </div>
            <br>
              <!-- Form Pencarian -->
            <form method="GET" action="{{ route('datasiswa.index') }}" class="flex w-full sm:w-auto mb-6">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari siswa..."
                    class="flex-1 border rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-64">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                    🔍 Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('datasiswa.index') }}"
                    class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Reset
                    </a>
                @endif
            </form>

           

            @include('components.footer')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeleteSiswa(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus siswa ini?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner('Menghapus...');
                document.getElementById('delete-siswa-form-' + id).submit();
            }
        });
    }

    function confirmDeleteAll() {
        Swal.fire({
            title: 'Hapus semua data siswa?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus Semua',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner('Menghapus semua...');
                document.getElementById('delete-all-form').submit();
            }
        });
    }

    function showSpinner(pesan = 'Memproses...') {
        Swal.fire({
            title: pesan,
            html: 'Mohon tunggu sebentar...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
</script>
@endpush
