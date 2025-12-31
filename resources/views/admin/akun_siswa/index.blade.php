@extends('layouts.app')
@section('title', 'Akun Siswa - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6">

           <!-- Header & Tombol Aksi -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
            
                <div class="flex flex-wrap gap-3 items-center">
            
                    <!-- Tombol Tambah -->
                    <a href="{{ route('admin.siswa.create') }}"
                        class="bg-blue-600 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow hover:bg-blue-700 transition-all whitespace-nowrap">
                        ➕ Tambah
                    </a>
            
                    <!-- Tombol Download Template -->
                    <a href="{{ route('admin.siswa.download-template') }}"
                        class="bg-green-600 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow hover:bg-green-700 transition-all whitespace-nowrap">
                        📄 Template
                    </a>
            
                    <!-- Form Import -->
                    <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" 
                        class="flex flex-wrap sm:flex-row gap-2 items-center">
                        @csrf
                        <input type="file" name="file" accept=".xlsx,.xls" required
                            class="border rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-auto">
                        <button type="submit"
                            class="bg-indigo-600 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow hover:bg-indigo-700 transition-all whitespace-nowrap">
                            ⬆️ Import
                        </button>
                    </form>
            
                    <!-- Tombol Hapus Semua -->
                    <form id="delete-all-form" action="{{ route('admin.siswa.deleteAll') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="confirmDeleteAll()"
                            class="bg-red-600 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow hover:bg-red-700 transition-all whitespace-nowrap">
                            🗑️ Hapus Semua
                        </button>
                    </form>
            
                </div>
            
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($siswas as $index => $siswa)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-3 whitespace-nowrap">{{ $siswas->firstItem() + $index }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $siswa->name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $siswa->email }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" 
                                        class="text-blue-600 hover:underline font-medium">
                                        Edit
                                    </a>

                                    <form id="delete-siswa-form-{{ $siswa->id }}" 
                                        action="{{ route('admin.siswa.destroy', $siswa->id) }}" 
                                        method="POST" 
                                        class="inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDeleteSiswa({{ $siswa->id }})" 
                                                class="text-red-600 hover:underline font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">
                                    Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $siswas->withQueryString()->links() }}
                </div>
                <br>
                
            </div>
                 <!-- Form Pencarian -->
                    <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex w-full sm:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari siswa..."
                            class="flex-1 border rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-48">

                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                            🔍 Cari
                        </button>

                        @if(request('search'))
                            <a href="{{ route('admin.siswa.index') }}"
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeleteSiswa(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus siswa ini?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner();
                document.getElementById('delete-siswa-form-' + id).submit();
            }
        });
    }

    function confirmDeleteAll() {
        Swal.fire({
            title: 'Hapus semua akun siswa?',
            text: "Semua data akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus semua',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner();
                document.getElementById('delete-all-form').submit();
            }
        });
    }

    function showSpinner() {
        Swal.fire({
            title: 'Memproses...',
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
