@extends('layouts.app')
@section('title', 'Admin Dashboard - smkhijaumuda')

@include('components.sidebar-admin')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Welcome to your Admin Dashboard</h1>

            <!-- Konten jumlah -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow">
                    <div class="text-sm font-medium">Akun Guru</div>
                    <div class="text-2xl font-bold mt-1">{{ $jumlahGuru }}</div>
                </div>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow">
                    <div class="text-sm font-medium">Akun siswa</div>
                    <div class="text-2xl font-bold mt-1">{{ $jumlahSiswa }}</div>
                </div>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow">
                    <div class="text-sm font-medium">Akun Tenaga Kependidikan</div>
                    <div class="text-2xl font-bold mt-1">{{ $jumlahTendik }}</div>
                </div>
            </div>

            <!-- Jumlah Siswa Per Kelas -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Jumlah Siswa per Kelas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($siswaPerKelas as $kelasNama => $siswas)
                        <div class="bg-white border-l-4 border-blue-400 p-4 rounded shadow-sm">
                            <div class="text-gray-700 text-sm font-medium">Kelas: {{ $kelasNama ?? '-' }}</div>
                            <div class="text-2xl font-bold text-blue-600">{{ $siswas->count() }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Jumlah Siswa Per Jurusan -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Jumlah Siswa per Jurusan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($siswaPerJurusan as $jurusan => $siswas)
                        <div class="bg-white border-l-4 border-green-400 p-4 rounded shadow-sm">
                            <div class="text-gray-700 text-sm font-medium">Jurusan: {{ $jurusan ?? '-' }}</div>
                            <div class="text-2xl font-bold text-green-600">{{ $siswas->count() }}</div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Konten lainnya -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-600">This is your main dashboard content area.</p>
            </div>
            @include('components.footer')
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