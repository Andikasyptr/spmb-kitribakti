@extends('layouts.app')
@include('components.sidebar-guru')
@section('title', 'Nilai Ujian: '.$exam->title)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">📊 Nilai Siswa - {{ $exam->title }}</h1>

        {{-- Export Excel --}}
        <a href="{{ route('guru.data-ujian-siswa.export', $exam->id) }}{{ http_build_query(request()->all()) ? '?'.http_build_query(request()->all()) : '' }}" 
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition mb-4 inline-block">
            ⬇️ Export Excel
        </a>

         {{-- Filter Form --}}
<form method="GET" class="mt-4 mb-4 flex flex-col sm:flex-row sm:flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[150px]">
        <label class="block text-sm font-medium text-gray-700">Kelas</label>
        <select name="kelas_id" class="w-full border px-2 py-1 rounded">
            <option value="">-- Semua Kelas --</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}" @selected(request('kelas_id') == $kelas->id)>{{ $kelas->nama_kelas }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex-1 min-w-[150px]">
        <label class="block text-sm font-medium text-gray-700">Jurusan</label>
        <select name="jurusan" class="w-full border px-2 py-1 rounded">
            <option value="">-- Semua Jurusan --</option>
            @foreach($jurusanList as $j)
                <option value="{{ $j }}" @selected(request('jurusan') == $j)>{{ $j }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex-1 min-w-[150px]">
        <label class="block text-sm font-medium text-gray-700">Kode Kelas</label>
        <select name="kode_kelas" class="w-full border px-2 py-1 rounded">
            <option value="">-- Semua --</option>
            <option value="1" @selected(request('kode_kelas') == '1')>1</option>
            <option value="2" @selected(request('kode_kelas') == '2')>2</option>
        </select>
    </div>

    <div class="flex gap-2 mt-2 sm:mt-0">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full sm:w-auto">
            Filter
        </button>
        <a href="{{ route('data-ujian-siswa.show', $exam->id) }}" 
           class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100 w-full sm:w-auto text-center">
            Reset
        </a>
    </div>
</form>

        {{-- Table Nilai --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-[700px] divide-y divide-gray-200 w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kode Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jurusan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $no = 1; @endphp
                    @forelse($siswas as $siswa)
                        @php
                            $userId = $siswa->user->id ?? null;
                            $res = $userId ? ($results[$userId] ?? null) : null;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $no++ }}</td>
                            <td class="px-4 py-2">{{ $siswa->user->name ?? 'Belum memiliki akun' }}</td>
                            <td class="px-4 py-2">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $siswa->kode_kelas ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $siswa->jurusan ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $res->score ?? 0 }}</td>
                            <td class="px-4 py-2">
                                {{ $res ? $res->created_at->format('d M Y') : '-' }}
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-gray-500">
                                Belum ada siswa terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

