@extends('layouts.app')
@section('title', 'Daftar Ujian - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <h1 class="text-2xl font-bold text-gray-800">📋 Daftar Ujian</h1>
        <a href="{{ route('admin.exams.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            + Tambah Ujian
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Desktop -->
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 text-left font-medium border-b">Judul</th>
                    <th class="p-3 text-left font-medium border-b">Kelas</th>
                    <th class="p-3 text-left font-medium border-b">Deskripsi</th>
                    <th class="p-3 text-left font-medium border-b">Durasi (menit)</th>
                    <th class="p-3 text-left font-medium border-b">Waktu Mulai</th>
                    <th class="p-3 text-left font-medium border-b">Waktu Selesai</th>
                    <th class="p-3 text-left font-medium border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 border-b text-gray-800">{{ $exam->title }}</td>
                        <td class="p-3 border-b text-gray-800">{{ $exam->kelas ?? '-' }}</td>
                        <td class="p-3 border-b text-gray-600">{{ Str::limit($exam->description, 50, '...') ?? '-' }}</td>
                        <td class="p-3 border-b text-gray-800">{{ $exam->duration }}</td>
                        <td class="p-3 border-b text-blue-600 font-semibold">
                            {{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="p-3 border-b text-orange-600 font-semibold">
                            {{ $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('d M Y H:i') : '-' }}
                        </td>

                        <td class="p-3 border-b">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('exam-questions.index', $exam->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition text-sm font-normal">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.exams.edit', $exam->id) }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition text-sm font-normal">
                                    Edit
                                </a>
                                <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="delete-exam-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="bg-blue-500 hover:bg-red-600 text-white px-3 py-1 rounded transition text-sm font-normal btn-delete">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Card Mobile -->
    <div class="grid gap-4 md:hidden">
        @foreach($exams as $exam)
            <div class="border rounded-lg p-4 shadow-sm flex flex-col gap-2">
                <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $exam->title }}</h2>
                <p class="text-sm text-gray-600 truncate">{{ $exam->description ?? '-' }}</p>
                <p class="text-sm text-gray-600">Kelas: {{ $exam->kelas ?? '-' }}</p>
                <p class="text-sm text-gray-600">Durasi: {{ $exam->duration }} menit</p>
                <p class="text-sm text-gray-600">Mulai: {{ $exam->start_time ? $exam->start_time->format('d M Y H:i') : '-' }}</p>
                <p class="text-sm text-gray-600">Selesai: {{ $exam->end_time ? $exam->end_time->format('d M Y H:i') : '-' }}</p>

                <div class="flex gap-2 mt-2">
                    <a href="{{ route('exam-questions.index', $exam->id) }}" 
                       class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded transition text-sm font-normal">
                        <i class="fas fa-eye mr-1"></i> 
                    </a>
                    <a href="{{ route('admin.exams.edit', $exam->id) }}" 
                       class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded transition text-sm font-normal">
                        <i class="fas fa-edit mr-1"></i> 
                    </a>
                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="flex-1 delete-exam-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                class="w-full text-center bg-blue-500 hover:bg-red-600 text-white px-3 py-2 rounded transition text-sm font-normal btn-delete">
                            <i class="fas fa-trash mr-1"></i> 
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection


@push('scripts')
<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    function toggleSidebar() {
        mobileSidebar.classList.toggle('-translate-x-full');
        sidebarBackdrop.classList.toggle('hidden');
    }
    if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', toggleSidebar);
    if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', toggleSidebar);

    // SweetAlert Hapus
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Yakin hapus ujian?',
                text: "Data ujian dan soal terkait akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
