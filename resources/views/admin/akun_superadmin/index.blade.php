@extends('layouts.app')
@section('title', ' Akun Super Admin - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 space-y-2 sm:space-y-0">
                <h1 class="text-lg sm:text-2xl font-bold text-gray-800">Daftar Akun Super Admin</h1>
                <a href="{{ route('admin.super-admin.create') }}"
                   class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm sm:text-base font-semibold py-2 px-5 rounded-lg shadow transition-all duration-300 ease-in-out transform hover:scale-105">
                    + Tambah Akun
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left whitespace-nowrap">No</th>
                            <th class="py-3 px-6 text-left whitespace-nowrap">Nama</th>
                            <th class="py-3 px-6 text-left whitespace-nowrap">Email</th>
                            <th class="py-3 px-6 text-left whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light">
                        @forelse($superAdmins as $index => $superAdmin)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="py-3 px-6 whitespace-nowrap">{{ $superAdmin->name }}</td>
                                <td class="py-3 px-6 whitespace-nowrap">{{ $superAdmin->email }}</td>
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <a href="{{ route('admin.super-admin.edit', $superAdmin->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                    <form id="delete-superadmin-form-{{ $superAdmin->id }}" action="{{ route('admin.super-admin.destroy', $superAdmin->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteSuperAdmin({{ $superAdmin->id }})" class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 px-6 text-center text-gray-500">Belum ada akun super admin.</td>
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
    function confirmDeleteSuperAdmin(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus akun ini?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner();
                document.getElementById('delete-superadmin-form-' + id).submit();
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