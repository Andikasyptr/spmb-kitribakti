@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Laporan Absensi Guru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Laporan Absensi Guru</h1>

    {{-- Filter dan Pencarian --}}
    <form action="{{ route('admin.absensi.laporan') }}" method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Cari Nama</label>
            <input type="text" name="nama" id="nama" value="{{ request('nama') }}"
                class="border rounded px-3 py-2 w-64" placeholder="Masukkan nama guru">
        </div>

        <div>
            <label for="bulan" class="block text-sm font-medium text-gray-700">Pilih Bulan</label>
            <select name="bulan" id="bulan" class="border rounded px-3 py-2 w-48">
                @foreach(range(1, 12) as $b)
                    @php
                        $bulanNama = \Carbon\Carbon::createFromDate(null, $b, 1)->translatedFormat('F');
                    @endphp
                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                        {{ $bulanNama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-3 mt-4">
    <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
        Filter
    </button>

   <a href="{{ route('admin.absensi.export.pdf', request()->query()) }}" target="_blank"
    class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded">
    Export PDF
</a>

</div>

        
    </form>

    {{-- Judul Dinamis --}}
    @php
        $bulanSekarang = request('bulan') 
            ? \Carbon\Carbon::createFromDate(null, request('bulan'), 1)->translatedFormat('F') 
            : \Carbon\Carbon::now()->translatedFormat('F');
    @endphp

    <h2 class="text-lg font-semibold mb-3">Data Absensi Guru - Bulan {{ $bulanSekarang }}</h2>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Senin</th>
                    <th class="border px-4 py-2">Selasa</th>
                    <th class="border px-4 py-2">Rabu</th>
                    <th class="border px-4 py-2">Kamis</th>
                    <th class="border px-4 py-2">Jumat</th>
                    <th class="border px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $row['no'] }}</td>
                        <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                        <td class="border px-4 py-2 text-center">{{ $row['senin'] }}</td>
                        <td class="border px-4 py-2 text-center">{{ $row['selasa'] }}</td>
                        <td class="border px-4 py-2 text-center">{{ $row['rabu'] }}</td>
                        <td class="border px-4 py-2 text-center">{{ $row['kamis'] }}</td>
                        <td class="border px-4 py-2 text-center">{{ $row['jumat'] }}</td>
                        <td class="border px-4 py-2 text-center font-semibold">{{ $row['total'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">Tidak ada data absensi.</td>
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