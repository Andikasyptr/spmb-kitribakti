@extends('layouts.app')
@include('components.sidebar-admin')
@section('content')
<div class="container mx-auto my-10 px-4 max-w-3xl">
    <h2 class="text-3xl font-bold mb-8 text-center">Pengaturan Tampilan</h2>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded shadow relative">
            {{ session('success') }}
            <button type="button" onclick="this.parentElement.style.display='none'" 
                class="absolute top-2 right-3 text-green-700 hover:text-green-900 font-bold">&times;</button>
        </div>
    @endif
    @if($settings)
    <a href="{{ route('admin.tampilan.edit') }}" 
       class="inline-block mb-6 px-4 py-2 bg-yellow-500 text-white font-semibold rounded hover:bg-yellow-600 transition duration-300">
        Edit Tampilan
    </a>
@endif
    <form method="POST" 
      action="{{ isset($settings) ? route('admin.tampilan.update') : route('admin.tampilan.store') }}">
    @csrf
    @if(isset($settings))
        @method('PUT')
    @endif

        <h4 class="text-xl font-semibold mb-4">Hero Section</h4>
        <div class="mb-6">
            <label for="hero_title" class="block mb-2 font-semibold text-gray-700">Judul</label>
            <input 
                type="text" 
                id="hero_title" 
                name="hero_title" 
                value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                placeholder="Masukkan judul hero section"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('hero_title') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('hero_title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-10">
            <label for="hero_description" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="hero_description" 
                name="hero_description" 
                rows="5"
                placeholder="Masukkan deskripsi hero section"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('hero_description') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
            @error('hero_description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <h4 class="text-xl font-semibold mb-4">Program Section</h4>
        <div class="mb-6">
            <label for="about_title" class="block mb-2 font-semibold text-gray-700">Judul</label>
            <input 
                type="text" 
                id="about_title" 
                name="about_title" 
                value="{{ old('about_title', $settings['about_title'] ?? '') }}"
                placeholder="Masukkan judul program section"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('about_title') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('about_title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="about_description" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="about_description" 
                name="about_description" 
                rows="5"
                placeholder="Masukkan deskripsi program section"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('about_description') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
            @error('about_description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button 
    type="submit" 
    class="w-full max-w-xl py-3 {{ isset($settings) ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }} 
           text-white font-semibold rounded-lg transition duration-300 shadow-md hover:shadow-lg">
    {{ isset($settings) ? 'Update' : 'Simpan' }}
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