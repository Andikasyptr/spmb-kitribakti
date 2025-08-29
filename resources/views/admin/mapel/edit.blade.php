{{-- resources/views/admin/mapel/edit.blade.php --}}
@extends('layouts.app')
@include('components.sidebar-admin')

@section('title', 'Edit Mata Pelajaran - smkhijaumuda')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">✏️ Edit Mata Pelajaran</h1>

    {{-- Form Edit Mapel --}}
    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg">
        <form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Mapel --}}
            <div class="mb-4">
                <label for="nama_mapel" class="block text-gray-700 font-medium mb-2">Nama Mapel</label>
                <input type="text" name="nama_mapel" id="nama_mapel" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                       value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('mapel.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    ⬅️ Kembali
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
