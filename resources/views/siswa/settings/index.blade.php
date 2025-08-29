@extends('layouts.app')
@section('title', 'siswa setting - smkhijaumuda')
@include('components.sidebar-siswa')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan</h1>

            <!-- Link ke profil siswa -->
            <div class="mb-2">
                <h2>
                    <a href="{{ route('profile.siswa') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Profil
                    </a>
                </h2>
            </div>
            <div class="mb-2">
                <h2>
                    <a href="{{ route('siswa.ubahsandi') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Ubah Kata Sandi
                    </a>
                </h2>
            </div>
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
