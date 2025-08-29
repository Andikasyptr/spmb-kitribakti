@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Data Absensi Guru')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Data Absensi Guru</h1>
    <div class="flex justify-end mb-4 gap-2">
    <a href="{{ route('admin.absensi.laporan') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Lihat Laporan</a>
</div>

    @include('admin.absensi._table', ['absensis' => $absensis])
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