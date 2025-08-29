@extends('layouts.app')
@section('title', 'Pindahkan Data Siswa')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

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

        <h1 class="text-2xl font-bold text-gray-700 mb-6">Data Siswa Keluar</h1>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NISN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
   @forelse ($siswas as $siswa)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nama }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nisn }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                {{ $siswa->status == 'keluar' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($siswa->status) }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right">
    <div class="flex justify-end space-x-2">
        <!-- Tombol Lihat -->
        <a href="{{ route('siswapindahan.show', $siswa->id) }}"
            class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
            Lihat
        </a>

        <!-- Tombol Hapus -->
        <form id="delete-pindahan-form-{{ $siswa->id }}" action="{{ route('siswapindahan.destroy', $siswa->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="button"
                onclick="confirmDeletePindahan({{ $siswa->id }})"
                class="px-3 py-1.5 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition">
                Hapus
            </button>
        </form>

        <!-- Tombol Move (Kembalikan ke Siswa Aktif) -->
        <form id="move-pindahan-form-{{ $siswa->id }}" action="{{ route('arsip.siswa.kembalikan') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
            <button type="button"
                onclick="confirmMoveSiswa({{ $siswa->id }})"
                class="px-3 py-1.5 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 transition">
                Moves
            </button>
        </form>
    </div>
</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data siswa keluar.</td>
    </tr>
@endforelse
</tbody>

            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeletePindahan(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus data siswa pindahan ini?',
            text: "Data akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    html: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        document.getElementById('delete-pindahan-form-' + id).submit();
                    }
                });
            }
        });
    }

    function confirmMoveSiswa(id) {
        Swal.fire({
            title: 'Kembalikan siswa ke data aktif?',
            text: "Data akan dipindahkan kembali ke tabel siswa aktif.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#38a169',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Kembalikan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memindahkan...',
                    html: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        document.getElementById('move-pindahan-form-' + id).submit();
                    }
                });
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
