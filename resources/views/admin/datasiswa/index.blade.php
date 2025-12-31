@extends('layouts.app')
@section('title', 'Data Siswa - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('datasiswa.index') }}" class="flex flex-col sm:flex-row sm:flex-wrap gap-3 mb-6 items-start sm:items-end">
                <div class="flex flex-col w-full sm:w-auto">
                    <label class="text-sm font-medium text-gray-600 mb-1">Nama</label>
                    <input type="text" name="nama" value="{{ request('nama') }}"
                        placeholder="Cari berdasarkan nama"
                        class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-full sm:w-64">
                </div>

                <div class="flex flex-col w-full sm:w-auto">
                    <label class="text-sm font-medium text-gray-600 mb-1">NISN</label>
                    <input type="text" name="nisn" value="{{ request('nisn') }}"
                        placeholder="Cari berdasarkan NISN"
                        class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-full sm:w-64">
                </div>

                <div class="flex flex-col w-full sm:w-auto">
                    <label class="text-sm font-medium text-gray-600 mb-1">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ request('jurusan') }}"
                        placeholder="Cari berdasarkan jurusan"
                        class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-full sm:w-64">
                </div>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full sm:w-auto">
                        🔍 Cari
                    </button>

                    @if(request()->has('nama') || request()->has('nisn') || request()->has('jurusan'))
                        <a href="{{ route('datasiswa.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition w-full sm:w-auto text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{!! session('error') !!}</div>
            @endif

            <!-- Tabel Data -->
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 text-sm">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold">NISN</th>
                            {{-- <th class="px-4 py-3 text-left font-semibold">Kelas</th> --}}
                            <th class="px-4 py-3 text-left font-semibold">Jurusan</th>
                            <th class="px-4 py-3 text-left font-semibold">JK</th>
                            <th class="px-4 py-3 text-left font-semibold">Agama</th>
                            <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($siswas as $index => $siswa)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $siswas->firstItem() + $index }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $siswa->nama }}</td>
                                <td class="px-4 py-3">{{ $siswa->nisn }}</td>
                                {{-- <td class="px-4 py-3">{{ $siswa->kelas->nama_kelas ?? 'Belum diatur' }}</td> --}}
                                <td class="px-4 py-3">{{ $siswa->jurusan }}</td>
                                <td class="px-4 py-3">{{ $siswa->jenis_kelamin }}</td>
                                <td class="px-4 py-3">{{ $siswa->agama }}</td>
                                <td class="px-4 py-3 text-right">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <!-- Tombol Lihat -->
                                    <a href="{{ route('datasiswa.show', $siswa->id) }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm whitespace-nowrap">
                                        Lihat
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form id="delete-siswa-form-{{ $siswa->id }}" action="{{ route('datasiswa.destroy', $siswa->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteSiswa({{ $siswa->id }})"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm whitespace-nowrap">
                                            Hapus
                                        </button>
                                    </form>

                                    <!-- Tombol Move -->
                                    <form id="move-siswa-form-{{ $siswa->id }}" action="{{ route('arsip.siswa.keluar') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                        <button type="button" onclick="confirmMoveSiswa({{ $siswa->id }})"
                                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm whitespace-nowrap">
                                            Move
                                        </button>
                                    </form>
                                </div>
                            </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-6 text-gray-500">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $siswas->withQueryString()->links() }}
            </div>

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

    function showSpinner(pesan = 'Memproses...') {
        Swal.fire({
            title: pesan,
            html: 'Mohon tunggu sebentar...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });
    }
    
    function confirmMoveSiswa(id) {
    Swal.fire({
        title: 'Yakin ingin memindahkan siswa ini?',
        text: "Siswa akan dipindahkan ke arsip!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f6ad55',
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
        html: 'Mohon tunggu sebentar...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading()
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
