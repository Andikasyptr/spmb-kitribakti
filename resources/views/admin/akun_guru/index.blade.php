@extends('layouts.app')
@section('title', 'Akun Guru - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2 sm:gap-0">
                <h1 class="text-xl font-bold text-gray-800">Daftar Akun Guru</h1>
                <a href="{{ route('admin.guru.create') }}"
                class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow transition-all duration-300 ease-in-out transform hover:scale-105">
                    + Tambah Akun
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100 text-sm uppercase text-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left whitespace-nowrap">No</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Nama</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Email</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @forelse($gurus as $index => $guru)
                            <tr class="border-b">
                                <td class="px-6 py-2 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-2 whitespace-nowrap">{{ $guru->name }}</td>
                                <td class="px-6 py-2 whitespace-nowrap">{{ $guru->email }}</td>
                                <td class="px-6 py-2 whitespace-nowrap">
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                    <form id="delete-guru-form-{{ $guru->id }}" action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteGuru({{ $guru->id }})" class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Belum ada data guru.</td>
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
    function confirmDeleteGuru(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus guru ini?',
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
                document.getElementById('delete-guru-form-' + id).submit();
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
