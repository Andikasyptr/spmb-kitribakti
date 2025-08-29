{{-- resources/views/admin/siswa/index.blade.php --}}

@extends('layouts.app')
@section('title', 'Data Siswa')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Feedback --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {!! session('error') !!}
            </div>
        @endif

        {{-- Konten lainnya --}}
        {{-- Form Upload Import --}}
        <div class="mb-6 w-full">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <h1 class="text-2xl font-semibold text-gray-700">Data Siswa</h1>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('datasiswa.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition text-center">
                            + Tambah Siswa
                        </a>

                        <a href="{{ route('datasiswa.download-template') }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 shadow text-center">
                            📥 Download Template
                        </a>

                        <form action="{{ route('datasiswa.import') }}" method="POST" enctype="multipart/form-data"
                              class="flex flex-wrap items-center gap-2">
                            @csrf
                            <input type="file" name="file" accept=".xlsx, .xls"
                                   class="border rounded p-2">
                            <button type="submit"
                                    class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 shadow">
                                ⬆️ Import Data
                            </button>
                        </form>
                    </div>
                </div>
     {{-- Filter Form --}}
        <form method="GET" action="{{ route('datasiswa.index') }}" class="mb-6 flex flex-col md:flex-row gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                <select name="tahun_ajaran" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    @foreach ($tahunAjaranList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas_id" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                <select name="jurusan" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    @foreach ($jurusanList as $j)
                        <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>
                            {{ $j }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                <select name="kode_kelas" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    <option value="1" {{ request('kode_kelas') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ request('kode_kelas') == '2' ? 'selected' : '' }}>2</option>
                </select>
            </div>


            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    Filter
                </button>
                <a href="{{ route('datasiswa.index') }}" class="ml-2 text-sm px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">
                    Reset
                </a>
            </div>
        </form>
        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divie-gray-200">
    <thead class="bg-gray-50">
    <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JK</th> <!-- Tambahan -->
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agama</th> <!-- Tambahan -->
        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
    </tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @foreach ($siswas as $siswa)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nama }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nisn }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->jurusan }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->agama }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right">
                <a href="{{ route('datasiswa.show', $siswa->id) }}" class="text-blue-600 hover:underline">Lihat</a>

                <form id="delete-siswa-form-{{ $siswa->id }}" action="{{ route('datasiswa.destroy', $siswa->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDeleteSiswa({{ $siswa->id }})" class="text-red-600 hover:underline ml-2">Hapus</button>
                </form>

                <form id="move-siswa-form-{{ $siswa->id }}" action="{{ route('arsip.siswa.keluar') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                    <button type="button" onclick="confirmMoveSiswa({{ $siswa->id }})" class="text-yellow-600 hover:underline ml-2">Move</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeleteSiswa(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus data siswa ini?',
            text: "Data tidak bisa dikembalikan!",
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

    function confirmMoveSiswa(id) {
        Swal.fire({
            title: 'Pindahkan Data Siswa?',
            text: "Data akan dipindahkan ke arsip (siswa keluar)",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Pindahkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner('Memindahkan...');
                document.getElementById('move-siswa-form-' + id).submit();
            }
        });
    }

    function showSpinner(pesan = 'Memproses...') {
        Swal.fire({
            title: pesan,
            html: 'Mohon tunggu sebentar.',
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