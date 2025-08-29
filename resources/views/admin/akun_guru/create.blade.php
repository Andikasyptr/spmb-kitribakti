@extends('layouts.app')
@section('title', 'Tambah Guru - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-lg font-bold mb-4 text-gray-800">Tambah Akun Guru</h1>

        <form method="POST" action="{{ route('admin.guru.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full mt-1 border rounded px-3 py-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full mt-1 border rounded px-3 py-2">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full mt-1 border rounded px-3 py-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full mt-1 border rounded px-3 py-2">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Simpan</button>
            </div>
        </form>
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