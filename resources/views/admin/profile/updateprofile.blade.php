@extends('layouts.app')
@section('title', 'Admin Update Profile - Zubayr Archery')
@include('components.sidebar-admin')

@section('content')
<div class="max-w-xl mx-auto py-6">
    <div class="bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-6">Edit Profil</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" 
                    value="{{ old('name', auth()->user()->name) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" 
                    value="{{ old('email', auth()->user()->email) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nik" class="block font-medium text-gray-700">Nomot Induk Kepegawaian</label>
                <input type="text" name="nik" id="nik" 
                    value="{{ old('nik', auth()->user()->nik) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_hp" class="block font-medium text-gray-700">Nomor Handphone</label>
                <input type="text" name="no_hp" id="no_hp" 
                    value="{{ old('no_hp', auth()->user()->no_hp) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="alamat" class="block font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('alamat', auth()->user()->profileAdmin->alamat ?? '') }}</textarea>
                @error('alamat')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="foto" class="block font-medium text-gray-700">Foto Profil (opsional)</label>
                <input type="file" name="foto" id="foto" class="w-full">
                @if(auth()->user()->profileAdmin && auth()->user()->profileAdmin->foto)
                    <img src="{{ asset('storage/' . auth()->user()->profileAdmin->foto) }}" alt="Foto Profil" class="w-24 mt-2 rounded">
                @endif
                @error('foto')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 transition">
                Simpan Perubahan
            </button>
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
