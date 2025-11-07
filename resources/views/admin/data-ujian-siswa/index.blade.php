@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Data Ujian Siswa')

@section('content')
<div class="p-4 sm:p-6">
    <h1 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-gray-800">
        📑 Data Ujian Siswa
    </h1>

    {{-- 🧾 Tombol Export Excel dan Filter --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <a href="#" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg w-full sm:w-auto text-center transition">
        Export
    </a>

        <form method="GET" action="{{ route('data-ujian-siswa.index') }}" 
              class="w-full sm:w-auto grid grid-cols-1 sm:grid-cols-5 gap-3">

            {{-- Dropdown Kelas --}}
            <select name="kelas" 
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                <option value="">-- Semua Kelas --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>

            {{-- Dropdown Jurusan --}}
            <select name="jurusan" 
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                <option value="">-- Semua Jurusan --</option>
                <option value="TKJ">Teknik Komputer Jaringan</option>
                <option value="RPL">Rekayasa Perangkat Lunak</option>
                <option value="TBSM">Teknik Sepeda Motor</option>
            </select>

            {{-- Dropdown Kode Kelas --}}
            <select name="kode_kelas" 
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                <option value="">-- Semua Kode --</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>

            {{-- Tombol Filter --}}
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition w-full">
                Filter
            </button>

            {{-- Tombol Reset --}}
            <a href="{{ route('data-ujian-siswa.index') }}" 
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition w-full text-center">
                Reset
            </a>
        </form>
    </div>

    {{-- 📋 Tabel Data Ujian --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-100 text-gray-700 text-xs sm:text-sm">
                <tr>
                    <th class="px-3 sm:px-4 py-2">No</th>
                    <th class="px-3 sm:px-4 py-2">Mata Pelajaran</th>
                    <th class="px-3 sm:px-4 py-2">Jurusan</th>
                    <th class="px-3 sm:px-4 py-2">Kelas</th>
                    <th class="px-3 sm:px-4 py-2">Tanggal Dibuat</th>
                    <th class="px-3 sm:px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($exams as $index => $exam)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-3 sm:px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-3 sm:px-4 py-2">{{ $exam->title }}</td>
                        <td class="px-3 sm:px-4 py-2">{{ $exam->description }}</td>
                        <td class="px-3 sm:px-4 py-2">{{ $exam->kelas ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2 whitespace-nowrap">
                            {{ $exam->created_at->format('d M Y') }}
                        </td>
                        <td class="px-3 sm:px-4 py-2 text-center">
                            <a href="{{ route('data-ujian-siswa.show', $exam->id) }}" 
                               class="inline-block bg-blue-600 text-white px-3 py-1 rounded-lg text-xs sm:text-sm hover:bg-blue-700 transition">
                                Lihat Nilai
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                            Belum ada data ujian
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
    const toggle = document.getElementById('mobile-menu-toggle');
    const sidebar = document.getElementById('mobile-sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden');
    }

    if (toggle) toggle.addEventListener('click', toggleSidebar);
    if (backdrop) backdrop.addEventListener('click', toggleSidebar);
});
</script>
@endpush
