{{-- resources/views/admin/e-learning/index.blade.php --}}
@extends('layouts.app')
@include('components.sidebar-admin')

@section('title', 'Admin - E-Learning (Fitur Ujian)')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Judul Halaman -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 13.5c0 4.142-3.358 7.5-7.5 7.5h-3a7.5 7.5 0 01-7.5-7.5c0-.94.166-1.84.472-2.663L12 14z" />
                </svg>
                Manajemen Ujian
            </h1>
            <a href="{{ route('admin.exam.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                + Tambah Ujian
            </a>
        </div>

        <!-- Daftar Ujian -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-sm uppercase">
                        <th class="px-6 py-3">Judul Ujian</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Durasi</th>
                        <th class="px-6 py-3">Jumlah Soal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium">{{ $exam->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($exam->description, 50) }}</td>
                            <td class="px-6 py-4">{{ $exam->duration }} menit</td>
                            <td class="px-6 py-4">{{ $exam->total_questions }}</td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <a href="{{ route('admin.exam.edit', $exam->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                                <form action="{{ route('admin.exam.delete', $exam->id) }}" method="POST" onsubmit="return confirm('Yakin hapus ujian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada ujian</td>
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
