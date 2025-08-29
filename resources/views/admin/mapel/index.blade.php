@extends('layouts.app')

@section('title', 'Daftar Mata Pelajaran')

@include('components.sidebar-admin')
@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg">

    <h2 class="text-2xl font-bold text-gray-700 mb-4">📚 Daftar Mata Pelajaran</h2>

    <!-- Alert -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah Mapel -->
    <form action="{{ route('mapel.store') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex items-center gap-2">
            <input type="text" name="nama_mapel" class="border p-2 rounded w-full" placeholder="Nama Mata Pelajaran" required>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Tambah</button>
        </div>
        @error('nama_mapel')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </form>

    <!-- Tabel Mapel -->
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="bg-orange-500 text-black text-sm uppercase">
                    <th class="py-3 px-4 text-center">No</th>
                    <th class="py-3 px-4">Nama Mata Pelajaran</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mapels as $mapel)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition">
                        <!-- Nomor urut -->
                        <td class="py-3 px-4 text-center font-medium text-gray-700">{{ $loop->iteration }}</td>
                        <!-- Nama mapel -->
                        <td class="py-3 px-4 text-gray-700">{{ $mapel->nama_mapel }}</td>
                        <!-- Aksi -->
                        <td class="py-3 px-4 text-center">
    <div class="flex justify-center gap-2">
        <!-- Tombol Edit -->
        <a href="{{ route('mapel.edit', $mapel->id) }}" 
           class="px-3 py-1 bg-orange-400 text-gray-900 font-semibold rounded-lg shadow hover:bg-orange-500 transition">
            Edit
        </a>

        <!-- Tombol Hapus -->
        <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST" 
              onsubmit="return confirm('Yakin hapus mapel ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-3 py-1 bg-orange-500 text-black font-semibold rounded-lg shadow hover:bg-red-600 transition">
                Hapus
            </button>
        </form>
    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500 italic">Belum ada data mata pelajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
