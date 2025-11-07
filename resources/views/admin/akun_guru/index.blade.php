@extends('layouts.app')
@section('title', 'Akun Guru - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6">

            <!-- Header & Tombol Aksi -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">

                <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                    <!-- Tombol Tambah -->
                    <a href="{{ route('admin.guru.create') }}"
                        class="bg-blue-600 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow hover:bg-blue-700 transition-all">
                        ➕ Tambah
                    </a>

                    <!-- Tombol Download Template -->
                    <a href="{{ route('admin.guru.downloadTemplate') }}"
                        class="bg-green-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-700 transition-all">
                        📄 Template
                    </a>

                    <!-- Form Import -->
                    <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data"
                        class="flex flex-col sm:flex-row gap-2 items-center">
                        @csrf
                        <input type="file" name="file" accept=".xlsx,.xls" required
                            class="border rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-auto">
                        <button type="submit"
                            class="bg-indigo-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow hover:bg-indigo-700 transition-all">
                            ⬆️ Import
                        </button>
                    </form>

                    <!-- Tombol Hapus Semua -->
                    <form id="delete-all-form" action="{{ route('admin.guru.deleteAll') }}" method="POST">
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

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
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
                        @forelse($gurus as $index => $guru)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-3 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $guru->name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $guru->email }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                                        class="text-blue-600 hover:underline font-medium">
                                        Edit
                                    </a>

                                    <form id="delete-guru-form-{{ $guru->id }}" 
                                        action="{{ route('admin.guru.destroy', $guru->id) }}" 
                                        method="POST" 
                                        class="inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDeleteGuru({{ $guru->id }})" 
                                                class="text-red-600 hover:underline font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">
                                    Belum ada data guru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <br>

                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('admin.guru.index') }}" class="flex w-full sm:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari guru..."
                        class="flex-1 border rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400 w-full sm:w-48">

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                        🔍 Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.guru.index') }}"
                        class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Reset
                        </a>
                    @endif
                </form>

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
                document.getElementById('delete-guru-form-' + id).submit();
            }
        });
    }

    function confirmDeleteAll() {
        Swal.fire({
            title: 'Hapus semua akun guru?',
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
