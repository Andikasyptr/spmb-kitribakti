@extends('layouts.app')
@section('title', 'Tenaga Kependidikan - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2 sm:gap-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Daftar Tenaga Kependidikan</h1>
                <a href="{{ route('admin.tendik.create') }}"
                   class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm sm:text-base font-semibold py-2 px-5 rounded-lg shadow transition-all duration-300 ease-in-out transform hover:scale-105">
                    + Tambah
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border text-sm">
                    <thead class="bg-gray-100 text-gray-700 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left whitespace-nowrap">No</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Nama</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Email</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffs as $index => $staff)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-2 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-2 whitespace-nowrap">{{ $staff->name }}</td>
                                <td class="px-6 py-2 whitespace-nowrap">{{ $staff->email }}</td>
                                <td class="px-6 py-2 whitespace-nowrap">
                                    <a href="{{ route('admin.tendik.edit', $staff->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form id="delete-tendik-form-{{ $staff->id }}" action="{{ route('admin.tendik.destroy', $staff->id) }}" method="POST" class="inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteTendik({{ $staff->id }})" class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @include('components.footer')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteTendik(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: 'Tindakan ini tidak bisa dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner();
                document.getElementById('delete-tendik-form-' + id).submit();
            }
        });
    }

    function showSpinner() {
        Swal.fire({
            title: 'Menghapus...',
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