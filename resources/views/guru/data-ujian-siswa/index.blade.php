@extends('layouts.app')
@include('components.sidebar-guru')
@section('title', 'Data Ujian Siswa')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">📑 Data Ujian Siswa</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Judul Ujian</th>
                    <th class="px-4 py-2">Jurusan</th>
                    <th class="px-4 py-2">Kelas</th>
                    <th class="px-4 py-2">Tanggal Dibuat</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($exams as $index => $exam)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $exam->title }}</td>
                    <td class="px-4 py-2">{{ $exam->description }}</td>
                    <td class="px-4 py-2">
                        {{ $exam->kelas }}
                    </td>
                    <td class="px-4 py-2">{{ $exam->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-2 flex gap-2 flex-wrap">
                        <a href="{{ route('guru.data-ujian-siswa.show', $exam->id) }}" 
                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Lihat Nilai
                        </a>
                        <!--<a href="{{ route('guru.data-ujian-siswa.export', $exam->id) }}" -->
                        <!--   class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">-->
                        <!--    Export Excel-->
                        <!--</a>-->
                    </td>
                </tr>
                @endforeach
                @if($exams->isEmpty())
                <tr>
                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                        Belum ada data ujian
                    </td>
                </tr>
                @endif
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


