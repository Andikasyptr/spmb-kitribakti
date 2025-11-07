@extends('layouts.app')
@section('title', 'Tenaga Kependidikan - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6">

            <!-- Header & Tombol Aksi -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">

                <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                    <!-- Tombol Tambah -->
                    <a href="{{ route('admin.tendik.create') }}"
                        class="bg-blue-600 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow hover:bg-blue-700 transition-all">
                        ➕ Tambah
                    </a>

                    <!-- Tombol Download Template -->
                    <a href="{{ route('admin.tendik.download-template') }}"
                        class="bg-green-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-700 transition-all">
                        📄 Template
                    </a>

                    <!-- Form Import -->
                    <form action="{{ route('admin.tendik.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-2 items-center">
                        @csrf
                        <input type="file" name="file" accept=".xlsx,.xls" required
                            class="border rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-auto">
                        <button type="submit"
                            class="bg-indigo-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-indigo-700 transition-all">
                            ⬆️ Import
                        </button>
                    </form>

                    <!-- Tombol Hapus Semua -->
                    <form id="delete-all-form" action="{{ route('admin.tendik.deleteAll') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="confirmDeleteAll()"
                            class="bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-red-700 transition-all">
                            🗑️ Hapus Semua
                        </button>
                    </form>
                </div>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('admin.tendik.index') }}" class="flex w-full sm:w-auto mb-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari tenaga kependidikan..."
                    class="flex-1 border rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-64">

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                    🔍 Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.tendik.index') }}"
                       class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 shadow-lg rounded-lg overflow-hidden text-sm">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">No</th>
                            <th class="px-6 py-3 text-left font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left font-semibold">Email</th>
                            <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($staffs as $index => $staff)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-3 whitespace-nowrap">{{ $staffs->firstItem() + $index }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $staff->name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $staff->email }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.tendik.edit', $staff->id) }}" 
                                        class="text-blue-600 hover:underline font-medium">
                                        Edit
                                    </a>

                                    <form id="delete-tendik-form-{{ $staff->id }}" 
                                          action="{{ route('admin.tendik.destroy', $staff->id) }}" 
                                          method="POST" 
                                          class="inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDeleteTendik({{ $staff->id }})" 
                                                class="text-red-600 hover:underline font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">
                                    Belum ada data tenaga kependidikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $staffs->withQueryString()->links() }}
                </div>

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
                document.getElementById('delete-tendik-form-' + id).submit();
            }
        });
    }

    function confirmDeleteAll() {
        Swal.fire({
            title: 'Hapus semua akun tenaga kependidikan?',
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
