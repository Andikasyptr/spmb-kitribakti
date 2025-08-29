@extends('layouts.app')
@section('title', 'Superadmin Profile - smkhijaumuda')
@include('components.SuperAdmin_sidebar-admin')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Profil Superadmin</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <strong>Nama:</strong> {{ auth()->user()->name }}
        </div>
        <div class="mb-4">
            <strong>Email:</strong> {{ auth()->user()->email }}
        </div>
        <div class="mb-4">
            <strong>Nomor Induk Kependudukan:</strong> {{ $profile?->nik ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Nomor Handphone:</strong> {{ $profile?->no_hp ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Alamat:</strong> {{ $profile?->alamat ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Foto:</strong><br>
            @if($profile && $profile->foto)
                <img src="{{ asset('storage/' . $profile->foto) }}" alt="Foto Profil" class="w-32 rounded-lg">
            @else
                <p>Tidak ada foto</p>
            @endif
        </div>
        <a href="{{ route('superadmin.settings.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
        <a href="{{ route('superadmin.profile.edit') }}" class="inline-block mt-4 ml-10 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Edit Profil
        </a>
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
