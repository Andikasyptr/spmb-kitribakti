@extends('layouts.app')
@section('title', 'Akun Siswa - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2 sm:gap-0">
                <h1 class="text-xl font-bold text-gray-800">Daftar Akun Siswa</h1>
                <!-- Form Search -->
                <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari siswa..."
                        class="border rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.siswa.index') }}"
                        class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Reset
                        </a>
                    @endif
                </form>
                

                <a href="{{ route('admin.siswa.create') }}"
                   class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold py-2 px-5 rounded-lg shadow transition-all duration-300 ease-in-out transform hover:scale-105">
                    + Tambah
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

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
                                <!-- Gunakan firstItem() agar nomor mengikuti halaman -->
                                <td class="px-6 py-3 whitespace-nowrap">{{ $siswas->firstItem() + $index }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $siswa->name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $siswa->email }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" 
                                        class="text-blue-600 hover:underline font-medium">
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
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

                {{-- <!-- Info paginasi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4 text-sm text-gray-600">
                    <div>
                        Menampilkan 
                        <span class="font-semibold">{{ $siswas->firstItem() }}</span>
                        sampai 
                        <span class="font-semibold">{{ $siswas->lastItem() }}</span>
                        dari total 
                        <span class="font-semibold">{{ $siswas->total() }}</span>
                        siswa
                    </div> --}}
                    <div class="mt-2 sm:mt-7">
                        {{ $siswas->withQueryString()->links() }}
                    </div>
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
