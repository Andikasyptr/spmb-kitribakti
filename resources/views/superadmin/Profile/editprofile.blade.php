@extends('layouts.app')
@section('title', 'Super Admin Edit Profile - smkhijaumuda')
@include('components.SuperAdmin_sidebar-admin')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Profil</h1>

    <form action="{{ route('superadmin.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
    <label class="block font-medium">Nama</label>
    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border border-gray-700 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border border-gray-700 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium">Nomor Induk Kepegawaian</label>
            <input type="text" name="nik" value="{{ old('nik', auth()->user()->nik) }}" class="w-full border border-gray-700 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium">Nomor Handphone</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}" class="w-full border border-gray-700 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border border-gray-700 rounded">{{ old('alamat', $profile?->alamat) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Foto (opsional)</label>
            <input type="file" name="foto" class="w-full">
            @if($profile && $profile->foto)
                <img src="{{ asset('storage/' . $profile->foto) }}" class="w-24 mt-2 rounded" alt="Foto Profil">
            @endif
        </div>
        
        <a href="{{ route('superadmin.settings.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 ml-10 py-2 rounded">
            Simpan
        </button>
    </form>
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
