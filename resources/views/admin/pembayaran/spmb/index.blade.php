@extends('layouts.app')

@section('title', 'Data Pembayaran Siswa - Admin')
@include('components.sidebar-admin')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">💰 Data Pembayaran Siswa</h1>

    <!-- Filter Form -->
<form method="GET" action="{{ route('admin.pembayaran.index') }}" class="mb-6 flex flex-col sm:flex-row gap-4 items-start sm:items-end">
    <div class="flex flex-col w-full sm:w-auto">
        <label for="nama" class="text-gray-700 text-sm mb-1">Nama Siswa</label>
        <input type="text" name="nama" id="nama" value="{{ request('nama') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" 
               placeholder="Cari berdasarkan nama">
    </div>
    <div class="flex flex-col w-full sm:w-auto">
        <label for="nisn" class="text-gray-700 text-sm mb-1">NISN</label>
        <input type="text" name="nisn" id="nisn" value="{{ request('nisn') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" 
               placeholder="Cari berdasarkan NISN">
    </div>

    <!-- Container tombol -->
    <div class="flex flex-row gap-2 w-full sm:w-auto mt-2 sm:mt-0">
        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm transition duration-200">
        Filter
        </button>
        <a href="{{ route('admin.pembayaran.index') }}" 
           class="flex-1 bg-red-700 hover:bg-gray-500 text-white px-6 py-2 rounded-lg text-sm transition duration-200">
            Reset
        </a>
    </div>
</form>


    <!-- Tabel Data -->
    <div class="overflow-x-auto bg-white rounded-2xl shadow-md p-6 transition-all duration-300 hover:shadow-lg">
        <table class="min-w-full text-left border-collapse">
           <thead>
               <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                   <th class="px-6 py-3">No</th>
                   <th class="px-6 py-3">Nama Siswa</th>
                   <th class="px-6 py-3">NISN</th>
                   <th class="px-6 py-3">Jurusan</th>
                   <th class="px-6 py-3">Status</th>
                   <th class="px-6 py-3 text-center">Aksi</th>
               </tr>
           </thead>
           <tbody>
               @forelse ($pembayaran as $index => $item)
                   <tr class="border-b hover:bg-gray-50 transition duration-150">
                       <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                       <td class="px-6 py-4 font-medium text-gray-800">
                           {{ $item->user->siswa->nama ?? 'Tidak Diketahui' }}
                       </td>
                       <td class="px-6 py-4 text-gray-700">
                           {{ $item->user->siswa->nisn ?? '-' }}
                       </td>
                       <td class="px-6 py-4 text-gray-700">
                           {{ $item->user->siswa->jurusan ?? '-' }}
                       </td>
                       <td class="px-6 py-4 text-gray-700">
                           <span class="px-2 py-1 rounded text-sm 
                               {{ $item->status === 'Sudah Bayar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                               {{ $item->status }}
                           </span>
                       </td>
                       <td class="px-6 py-4 text-center">
                           <div class="flex flex-wrap justify-center gap-2">
                               @if ($item->bukti_pembayaran)
                                   <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}"
                                      target="_blank"
                                      class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm whitespace-nowrap">
                                       🔍 Lihat Bukti
                                   </a>
                               @endif

                               @if ($item->status === 'Menunggu Verifikasi')
                                   <form action="{{ route('admin.pembayaran.verifikasi', $item->id) }}" method="POST" class="inline-block">
                                       @csrf
                                       <button type="submit"
                                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 text-sm whitespace-nowrap">
                                           ✅ Verifikasi
                                       </button>
                                   </form>
                               @else
                                   <span class="text-gray-400 italic text-sm">Sudah diverifikasi</span>
                               @endif
                           </div>
                       </td>
                   </tr>
               @empty
                   <tr>
                       <td colspan="6" class="text-center py-6 text-gray-500">
                           Belum ada siswa yang mengupload bukti pembayaran.
                       </td>
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
