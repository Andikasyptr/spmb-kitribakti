@extends('layouts.app')
@section('title', 'guru setting - smkhijaumuda')
@include('components.sidebar-guru')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan</h1>

            <!-- Link ke profil admin -->
            <div class="mb-2">
                <h2>
                    <a href="{{ route ('guru.profile.index') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Profil
                    </a>
                </h2>
            </div>
            <div class="mb-2">
                <h2>
                    <a href="{{ route ('guru.ubahsandi') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Ubah Kata Sandi
                    </a>
                </h2>
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