@extends('layouts.app')
@section('title', 'Buat Ujian - smkhijaumuda')
@include('components.sidebar-guru')

@section('content')
<div class="p-4 sm:p-6 bg-white rounded-lg shadow max-w-lg mx-auto">
    <h1 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Tambah Ujian</h1>

    <form action="{{ route('guru.exams.index') }}" method="POST" class="space-y-5" id="formExam">
        @csrf

        <!-- Dropdown Mapel -->
        <div class="w-full">
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <div class="relative">
                <select id="mapel_id" name="mapel_id"
                    class="block w-full appearance-none border border-gray-300 bg-white p-3 rounded-lg text-gray-700 shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" 
                                data-nama="{{ $mapel->nama_mapel }}"
                                data-deskripsi="{{ $mapel->deskripsi ?? '' }}">
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Hidden input untuk title -->
        <input type="hidden" name="title" id="title">

        <!-- Dropdown Kelas -->
        <div class="w-full">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <div class="relative">
                <select id="kelas" name="kelas" 
                        class="block w-full appearance-none border border-gray-300 bg-white p-3 rounded-lg text-gray-700 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $kls)
                        <option value="{{ $kls->nama_kelas }}">{{ $kls->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Deskripsi (Jurusan) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
            <select name="description" id="description" 
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500 sm:text-sm">
                <option value="Semua Jurusan">Semua Jurusan</option>
                <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
                <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                <option value="Manajemen Perkantoran">Manajemen Perkantoran</option>
            </select>
        </div>

        <!-- Durasi -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Durasi (menit)</label>
            <input type="number" name="duration" min="1"
                   class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500 sm:text-sm" 
                   required>
        </div>

        <!-- Waktu Mulai -->
        <!--<div>-->
        <!--    <label class="block text-sm font-medium text-gray-700 mb-3">Waktu Mulai</label>-->
        <!--    <input type="datetime-local" name="start_time"-->
        <!--           class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500 sm:text-sm">-->
        <!--</div>-->

        <!-- Waktu Selesai -->
        <!--<div>-->
        <!--    <label class="block text-sm font-medium text-gray-700 mb-3">Waktu Selesai</label>-->
        <!--    <input type="datetime-local" name="end_time"-->
        <!--           class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500 sm:text-sm">-->
        <!--</div>-->
        
        <br>

        <!-- Tombol Submit -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectMapel = document.getElementById('mapel_id');
    const titleInput = document.getElementById('title');
    const descInput = document.getElementById('description');
    const formExam = document.getElementById('formExam');

    if (selectMapel && titleInput && descInput && formExam) {
        selectMapel.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            titleInput.value = selectedOption.getAttribute('data-nama') || '';
            descInput.value = selectedOption.getAttribute('data-deskripsi') || '';
        });

        formExam.addEventListener('submit', function() {
            const selectedOption = selectMapel.options[selectMapel.selectedIndex];
            titleInput.value = selectedOption.getAttribute('data-nama') || '';
        });
    }
});
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
