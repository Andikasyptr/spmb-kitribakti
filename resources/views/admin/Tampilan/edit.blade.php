

@extends('layouts.app')
@include('components.sidebar-admin')
@section('content')
<div class="container mx-auto my-10 px-4 max-w-3xl">
    <h2 class="text-3xl font-bold mb-8 text-center">Edit Pengaturan Tampilan</h2>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded shadow relative">
            {{ session('success') }}
            <button type="button" onclick="this.parentElement.style.display='none'" 
                class="absolute top-2 right-3 text-green-700 hover:text-green-900 font-bold">&times;</button>
        </div>
    @endif

    <form action="{{ route('admin.tampilan.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

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

        <div class="mb-6">
            <label for="title_program1" class="block mb-2 font-semibold text-gray-700">point 1</label>
            <input 
                type="text" 
                id="title_program1" 
                name="title_program1" 
                value="{{ old('title_program1', $settings['title_program2'] ?? '') }}"
                placeholder="Masukkan point pertama"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('title_program1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('title_program1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_program1" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_program1" 
                name="des_program1" 
                rows="5"
                placeholder="Masukkan deskripsi point pertama"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_program1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_program1', $settings['des_program1'] ?? '') }}</textarea>
            @error('des_program1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="title_program2" class="block mb-2 font-semibold text-gray-700">point 2</label>
            <input 
                type="text" 
                id="title_program2" 
                name="title_program2" 
                value="{{ old('title_program2', $settings['title_program2'] ?? '') }}"
                placeholder="Masukkan point pertama"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('title_program2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('title_program2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_program2" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_program2" 
                name="des_program2" 
                rows="5"
                placeholder="Masukkan deskripsi point pertama"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_program2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_program2', $settings['des_program2'] ?? '') }}</textarea>
            @error('des_program2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="title_program3" class="block mb-2 font-semibold text-gray-700">point 3</label>
            <input 
                type="text" 
                id="title_program3" 
                name="title_program3" 
                value="{{ old('title_program3', $settings['title_program3'] ?? '') }}"
                placeholder="Masukkan point pertama"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('title_program3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('title_program3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_program3" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_program3" 
                name="des_program3" 
                rows="5"
                placeholder="Masukkan deskripsi point pertama"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_program3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_program3', $settings['des_program3'] ?? '') }}</textarea>
            @error('des_program2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <div class="mb-6">
            <label for="program_image" class="block mb-2 font-semibold text-gray-700">Gambar Program</label>
            <input 
                type="file" 
                id="program_image" 
                name="program_image"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('program_image') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('program_image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['program_image']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['program_image']) }}" alt="Gambar Program" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        {{-- team --}}
        <h4 class="text-xl font-semibold mb-4">Team Section</h4>
        <div class="mb-6">
            <label for="team_title" class="block mb-2 font-semibold text-gray-700">Judul</label>
            <input 
                type="text" 
                id="team_title" 
                name="team_title" 
                value="{{ old('team_title', $settings['team_title'] ?? '') }}"
                placeholder="Masukkan judul"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_title') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="team_description" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="team_description" 
                name="team_description" 
                rows="5"
                placeholder="Masukkan deskripsi"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('about_description') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('team_description', $settings['about_description'] ?? '') }}</textarea>
            @error('team_description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="team_image1" class="block mb-2 font-semibold text-gray-700">foto</label>
            <input 
                type="file" 
                id="team_image1" 
                name="team_image1"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('team_image1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_image1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['team_image1']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['team_image1']) }}" alt="Gambar profil" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        <div class="mb-6">
            <label for="team_nama1" class="block mb-2 font-semibold text-gray-700">Nama</label>
            <input 
                type="text" 
                id="team_nama1" 
                name="team_nama1" 
                value="{{ old('team_nama1', $settings['team_nama1'] ?? '') }}"
                placeholder="Masukkan nama disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_nama1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_nama1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_image1" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_image1" 
                name="des_image1" 
                rows="2"
                placeholder="Masukkan deskripsi job disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_image2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_image1', $settings['des_image1'] ?? '') }}</textarea>
            @error('des_image1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="team_image2" class="block mb-2 font-semibold text-gray-700">foto</label>
            <input 
                type="file" 
                id="team_image2" 
                name="team_image2"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('team_image2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_image2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['team_image2']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['team_image2']) }}" alt="Gambar profil" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        <div class="mb-6">
            <label for="team_nama2" class="block mb-2 font-semibold text-gray-700">Nama</label>
            <input 
                type="text" 
                id="team_nama2" 
                name="team_nama2" 
                value="{{ old('team_nama2', $settings['team_nama2'] ?? '') }}"
                placeholder="Masukkan nama disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_nama2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_nama2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_image2" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_image2" 
                name="des_image2" 
                rows="2"
                placeholder="Masukkan deskripsi job disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_image2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_image2', $settings['des_image2'] ?? '') }}</textarea>
            @error('des_image2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="team_image3" class="block mb-2 font-semibold text-gray-700">foto</label>
            <input 
                type="file" 
                id="team_image3" 
                name="team_image3"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('team_image3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_image3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['team_image3']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['team_image3']) }}" alt="Gambar profil" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        <div class="mb-6">
            <label for="team_nama3" class="block mb-2 font-semibold text-gray-700">Nama</label>
            <input 
                type="text" 
                id="team_nama3" 
                name="team_nama3" 
                value="{{ old('team_nama3', $settings['team_nama3'] ?? '') }}"
                placeholder="Masukkan nama disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_nama3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_nama3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_image3" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_image3" 
                name="des_image3" 
                rows="2"
                placeholder="Masukkan deskripsi job disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_image3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_image3', $settings['des_image3'] ?? '') }}</textarea>
            @error('des_image3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="team_image4" class="block mb-2 font-semibold text-gray-700">foto</label>
            <input 
                type="file" 
                id="team_image4" 
                name="team_image4"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('team_image4') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_image4')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['team_image4']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['team_image4']) }}" alt="Gambar profil" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        <div class="mb-6">
            <label for="team_nama4" class="block mb-2 font-semibold text-gray-700">Nama</label>
            <input 
                type="text" 
                id="team_nama4" 
                name="team_nama4" 
                value="{{ old('team_nama4', $settings['team_nama4'] ?? '') }}"
                placeholder="Masukkan nama disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_nama4') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_nama4')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_image4" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_image4" 
                name="des_image4" 
                rows="2"
                placeholder="Masukkan deskripsi job disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_image4') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_image4', $settings['des_image4'] ?? '') }}</textarea>
            @error('des_image4')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="team_image5" class="block mb-2 font-semibold text-gray-700">foto</label>
            <input 
                type="file" 
                id="team_image5" 
                name="team_image5"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('team_image5') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_image5')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['team_image5']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['team_image5']) }}" alt="Gambar profil" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        <div class="mb-6">
            <label for="team_nama5" class="block mb-2 font-semibold text-gray-700">Nama</label>
            <input 
                type="text" 
                id="team_nama5" 
                name="team_nama5" 
                value="{{ old('team_nama5', $settings['team_nama5'] ?? '') }}"
                placeholder="Masukkan nama disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_nama5') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_nama5')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_image5" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_image5" 
                name="des_image5" 
                rows="2"
                placeholder="Masukkan deskripsi job disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_image5') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_image5', $settings['des_image5'] ?? '') }}</textarea>
            @error('des_image5')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="team_image6" class="block mb-2 font-semibold text-gray-700">foto</label>
            <input 
                type="file" 
                id="team_image6" 
                name="team_image6"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('team_image6') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_image6')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['team_image6']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['team_image6']) }}" alt="Gambar profil" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        <div class="mb-6">
            <label for="team_nama6" class="block mb-2 font-semibold text-gray-700">Nama</label>
            <input 
                type="text" 
                id="team_nama6" 
                name="team_nama6" 
                value="{{ old('team_nama6', $settings['team_nama6'] ?? '') }}"
                placeholder="Masukkan nama disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_nama6') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_nama6')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_image6" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_image6" 
                name="des_image6" 
                rows="2"
                placeholder="Masukkan deskripsi job disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_image6') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_image6', $settings['des_image6'] ?? '') }}</textarea>
            @error('des_image6')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="team_image7" class="block mb-2 font-semibold text-gray-700">foto</label>
            <input 
                type="file" 
                id="team_image7" 
                name="team_image7"
                accept="image/*"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                    border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                    transition duration-300
                    @error('team_image7') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_image7')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if(!empty($settings['team_image7']))
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Preview Gambar Saat Ini:</p>
                    <img src="{{ asset($settings['team_image7']) }}" alt="Gambar profil" class="w-48 h-auto rounded-md mt-2 border" />
                </div>
            @endif
        </div>
        <div class="mb-6">
            <label for="team_nama7" class="block mb-2 font-semibold text-gray-700">Nama</label>
            <input 
                type="text" 
                id="team_nama7" 
                name="team_nama7" 
                value="{{ old('team_nama7', $settings['team_nama7'] ?? '') }}"
                placeholder="Masukkan nama disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('team_nama7') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('team_nama7')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_image7" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_image7" 
                name="des_image7" 
                rows="2"
                placeholder="Masukkan deskripsi job disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_image7') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_image7', $settings['des_image7'] ?? '') }}</textarea>
            @error('des_image7')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <h4 class="text-xl font-semibold mb-4">Pricing Section</h4>
        <div class="mb-6">
            <label for="title_harga" class="block mb-2 font-semibold text-gray-700">Title</label>
            <input 
                type="text" 
                id="title_harga" 
                name="title_harga" 
                value="{{ old('title_harga', $settings['title_harga'] ?? '') }}"
                placeholder="Masukkan title"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('title_harga') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('title_harga')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_harga" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_harga" 
                name="des_harga" 
                rows="3"
                placeholder="Masukkan deskripsi"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('title_harga') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_harga', $settings['des_harga'] ?? '') }}</textarea>
            @error('des_harga')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="nama_kelas1" class="block mb-2 font-semibold text-gray-700">program ke-1</label>
            <input 
                type="text" 
                id="nama_kelas1" 
                name="nama_kelas1" 
                value="{{ old('nama_kelas1', $settings['nama_kelas1'] ?? '') }}"
                placeholder="Masukkan program pertama"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('nama_kelas1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('nama_kelas1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_kelas1" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_kelas1" 
                name="des_kelas1" 
                rows="2"
                placeholder="Masukkan deskripsi"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_kelas1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_kelas1', $settings['des_kelas1'] ?? '') }}</textarea>
            @error('des_kelas1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="harga_member" class="block mb-2 font-semibold text-gray-700">Harga Program ke-1</label>
            <textarea 
                id="harga_member" 
                name="harga_member" 
                rows="1"
                placeholder="Masukkan Harga"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('harga_member') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('harga_member', $settings['harga_member'] ?? '') }}</textarea>
            @error('harga_member')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="ben_member1" class="block mb-2 font-semibold text-gray-700">benefit ke-1</label>
            <textarea 
                id="ben_member1" 
                name="ben_member1" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_member1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_member1', $settings['ben_member1'] ?? '') }}</textarea>
            @error('ben_member1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="ben_member2" class="block mb-2 font-semibold text-gray-700">benefit ke-2</label>
            <textarea 
                id="ben_member2" 
                name="ben_member2" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_member2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_member2', $settings['ben_member2'] ?? '') }}</textarea>
            @error('ben_member2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="ben_member3" class="block mb-2 font-semibold text-gray-700">benefit ke-3</label>
            <textarea 
                id="ben_member3" 
                name="ben_member3" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_member3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_member3', $settings['ben_member3'] ?? '') }}</textarea>
            @error('ben_member3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="ben_member4" class="block mb-2 font-semibold text-gray-700">benefit ke-4</label>
            <textarea 
                id="ben_member4" 
                name="ben_member4" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_member4') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_member4', $settings['ben_member4'] ?? '') }}</textarea>
            @error('ben_member4')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="ben_member5" class="block mb-2 font-semibold text-gray-700">benefit ke-5</label>
            <textarea 
                id="ben_member5" 
                name="ben_member5" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_member5') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_member5', $settings['ben_member5'] ?? '') }}</textarea>
            @error('ben_member5')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>



        <div class="mb-6">
            <label for="nama_kelas2" class="block mb-2 font-semibold text-gray-700">program ke-2</label>
            <input 
                type="text" 
                id="nama_kelas2" 
                name="nama_kelas2" 
                value="{{ old('nama_kelas2', $settings['nama_kelas2'] ?? '') }}"
                placeholder="Masukkan program kedua"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300
                       @error('nama_kelas2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >
            @error('nama_kelas2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="des_kelas2" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="des_kelas2" 
                name="des_kelas2" 
                rows="2"
                placeholder="Masukkan deskripsi"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_kelas2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_kelas2', $settings['des_kelas2'] ?? '') }}</textarea>
            @error('des_kelas2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="harga_kunjungan" class="block mb-2 font-semibold text-gray-700">Harga Program ke-2</label>
            <textarea 
                id="harga_kunjungan" 
                name="harga_kunjungan" 
                rows="1"
                placeholder="Masukkan Harga"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('harga_kunjungan') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('harga_kunjungan', $settings['harga_kunjungan'] ?? '') }}</textarea>
            @error('harga_kunjungan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="ben_kunjungan1" class="block mb-2 font-semibold text-gray-700">benefit ke-1</label>
            <textarea 
                id="ben_kunjungan1" 
                name="ben_kunjungan1" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_kunjungan1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_kunjungan1', $settings['ben_kunjungan1'] ?? '') }}</textarea>
            @error('ben_kunjungan1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
         <div class="mb-6">
            <label for="ben_kunjungan2" class="block mb-2 font-semibold text-gray-700">benefit ke-2</label>
            <textarea 
                id="ben_kunjungan2" 
                name="ben_kunjungan2" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_kunjungan2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_kunjungan2', $settings['ben_kunjungan2'] ?? '') }}</textarea>
            @error('ben_kunjungan2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
         <div class="mb-6">
            <label for="ben_kunjungan3" class="block mb-2 font-semibold text-gray-700">benefit ke-3</label>
            <textarea 
                id="ben_kunjungan3" 
                name="ben_kunjungan3" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_kunjungan3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_kunjungan3', $settings['ben_kunjungan3'] ?? '') }}</textarea>
            @error('ben_kunjungan3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
         <div class="mb-6">
            <label for="ben_kunjungan4" class="block mb-2 font-semibold text-gray-700">benefit ke-4</label>
            <textarea 
                id="ben_kunjungan4" 
                name="ben_kunjungan4" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_kunjungan4') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_kunjungan4', $settings['ben_kunjungan4'] ?? '') }}</textarea>
            @error('ben_kunjungan4')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
         <div class="mb-6">
            <label for="ben_kunjungan5" class="block mb-2 font-semibold text-gray-700">benefit ke-5</label>
            <textarea 
                id="ben_kunjungan5" 
                name="ben_kunjungan5" 
                rows="1"
                placeholder="Masukkan benefit"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('ben_kunjungan5') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('ben_kunjungan5', $settings['ben_kunjungan5'] ?? '') }}</textarea>
            @error('ben_kunjungan5')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- FAQs --}}
        <h4 class="text-xl font-semibold mb-4">Pertanyaan Section</h4>
        <div class="mb-6">
            <label for="question1" class="block mb-2 font-semibold text-gray-700">pertanyaan ke-1</label>
            <textarea 
                id="question1" 
                name="question1" 
                rows="1"
                placeholder="Masukkan pertanyaan"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('question1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('question1', $settings['question1'] ?? '') }}</textarea>
            @error('question1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="answer1" class="block mb-2 font-semibold text-gray-700">jawaban</label>
            <textarea 
                id="answer1" 
                name="answer1" 
                rows="1"
                placeholder="Masukkan jawaban"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('answer1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('answer1', $settings['answer1'] ?? '') }}</textarea>
            @error('answer1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="question2" class="block mb-2 font-semibold text-gray-700">pertanyaan ke-2</label>
            <textarea 
                id="question2" 
                name="question2" 
                rows="1"
                placeholder="Masukkan pertanyaan"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('question2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('question2', $settings['question2'] ?? '') }}</textarea>
            @error('question2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="answer2" class="block mb-2 font-semibold text-gray-700">jawaban</label>
            <textarea 
                id="answer2" 
                name="answer2" 
                rows="1"
                placeholder="Masukkan jawaban"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('answer2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('answer2', $settings['answer2'] ?? '') }}</textarea>
            @error('answer2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="question3" class="block mb-2 font-semibold text-gray-700">pertanyaan ke-3</label>
            <textarea 
                id="question3" 
                name="question3" 
                rows="1"
                placeholder="Masukkan pertanyaan"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('question3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('question3', $settings['question3'] ?? '') }}</textarea>
            @error('question3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="answer3" class="block mb-2 font-semibold text-gray-700">jawaban</label>
            <textarea 
                id="answer3" 
                name="answer3" 
                rows="1"
                placeholder="Masukkan jawaban"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('answer3') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('answer3', $settings['answer3'] ?? '') }}</textarea>
            @error('answer3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="question4" class="block mb-2 font-semibold text-gray-700">pertanyaan ke-4</label>
            <textarea 
                id="question4" 
                name="question4" 
                rows="1"
                placeholder="Masukkan pertanyaan"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('question4') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('question4', $settings['question4'] ?? '') }}</textarea>
            @error('question4')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="answer4" class="block mb-2 font-semibold text-gray-700">jawaban</label>
            <textarea 
                id="answer4" 
                name="answer4" 
                rows="1"
                placeholder="Masukkan jawaban"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('answer4') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('answer4', $settings['answer1'] ?? '') }}</textarea>
            @error('answer4')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="question5" class="block mb-2 font-semibold text-gray-700">pertanyaan ke-5</label>
            <textarea 
                id="question5" 
                name="question5" 
                rows="1"
                placeholder="Masukkan pertanyaan"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('question5') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('question5', $settings['question5'] ?? '') }}</textarea>
            @error('question5')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="answer5" class="block mb-2 font-semibold text-gray-700">jawaban</label>
            <textarea 
                id="answer5" 
                name="answer5" 
                rows="1"
                placeholder="Masukkan jawaban"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('answer5') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('answer5', $settings['answer5'] ?? '') }}</textarea>
            @error('answer5')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- jadwal --}}
        <h4 class="text-xl font-semibold mb-4">jadwal Section</h4>
        <div class="mb-6">
            <label for="title_jadwal" class="block mb-2 font-semibold text-gray-700">title jadwal</label>
            <textarea 
                id="title_jadwal" 
                name="title_jadwal" 
                rows="1"
                placeholder="Masukkan judul"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('title_jadwal') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('title_jadwal', $settings['title_jadwal'] ?? '') }}</textarea>
            @error('title_jadwal')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="des_jadwal" class="block mb-2 font-semibold text-gray-700">deskripsi</label>
            <textarea 
                id="des_jadwal" 
                name="des_jadwal" 
                rows="2"
                placeholder="Masukkan deskripsi"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_jadwal') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_jadwal', $settings['des_jadwal'] ?? '') }}</textarea>
            @error('des_jadwal')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="jadwal1" class="block mb-2 font-semibold text-gray-700">jadwal program ke-1</label>
            <textarea 
                id="jadwal1" 
                name="jadwal1" 
                rows="1"
                placeholder="Masukkan nama program"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('jadwal1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('jadwal1', $settings['jadwal1'] ?? '') }}</textarea>
            @error('jadwal1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="des_jadwal1" class="block mb-2 font-semibold text-gray-700">jadwal ke-1</label>
            <textarea 
                id="des_jadwal1" 
                name="des_jadwal1" 
                rows="2"
                placeholder="Masukkan jadwal disini"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_jadwal1') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_jadwal1', $settings['des_jadwal1'] ?? '') }}</textarea>
            @error('des_jadwal1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="jadwal2" class="block mb-2 font-semibold text-gray-700">jadwal program ke-2</label>
            <textarea 
                id="jadwal2" 
                name="jadwal2" 
                rows="1"
                placeholder="Masukkan nama program"
                class="w-full max-w-xl px-4 py-2 border-2 rounded-lg
                       border-gray-300  focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('jadwal2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('jadwal2', $settings['jadwal2'] ?? '') }}</textarea>
            @error('jadwal2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="des_jadwal2" class="block mb-2 font-semibold text-gray-700">jadwal ke-2</label>
            <textarea 
                id="des_jadwal2" 
                name="des_jadwal2" 
                rows="2"
                placeholder="Masukkan jadwal disini"
                class="w-full max-w-xl px-4 mr-100 py-2 border-2 rounded-lg
                       border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300
                       transition duration-300 resize-y
                       @error('des_jadwal2') border-red-500 ring-red-300 focus:ring-red-500 @enderror"
            >{{ old('des_jadwal2', $settings['des_jadwal2'] ?? '') }}</textarea>
            @error('des_jadwal2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit" 
            class="w-full max-w-xl py-3 bg-blue-600 text-white font-semibold rounded-lg
                   hover:bg-blue-700 transition duration-300 shadow-md hover:shadow-lg"
        >
            Update
        </button>
        <a 
        href="{{ route('admin.settings') }}"
        class="block text-center mt-5 w-full max-w-xl py-3 bg-red-600 text-white font-semibold rounded-lg
            hover:bg-red-700 transition duration-300 shadow-md hover:shadow-lg"
    >
        Batalkan
    </a>

        
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