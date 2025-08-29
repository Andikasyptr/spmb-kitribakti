@extends('layouts.app')

@section('title', 'Data Pegawai')
@include('components.sidebar-admin')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-3">
    <h2 class="text-2xl font-semibold">Data Pegawai</h2>
    <a href="{{ route('pegawai.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center w-full md:w-auto">
       + Tambah Pegawai
    </a>
</div>


    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jenis Pegawai</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jabatan</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
    @forelse ($pegawais as $pegawai)
        <tr>
            <td class="px-4 py-2">{{ $loop->iteration }}</td>
            <td class="px-4 py-2">{{ $pegawai->nama }}</td>
            <td class="px-4 py-2">{{ $pegawai->email }}</td>
            <td class="px-4 py-2 capitalize">{{ $pegawai->jenis_pegawai }}</td>
            <td class="px-4 py-2">{{ $pegawai->jabatan }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="text-blue-600 hover:underline">Lihat</a>

                <form id="delete-form-{{ $pegawai->id }}" action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete({{ $pegawai->id }})" class="text-red-600 hover:underline">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada data pegawai.</td>
        </tr>
    @endforelse
</tbody>

        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner(); // Tampilkan spinner
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function showSpinner() {
        Swal.fire({
            title: 'Menghapus...',
            html: 'Mohon tunggu.',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false
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