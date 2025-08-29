@extends('layouts.app')
@section('title', 'Edit Jurusan')
@include('components.sidebar-admin')
@section('content')

<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Edit Jurusan</h2>
    <form action="{{ route('jurusan.update', $jurusan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label class="block mb-2">Nama Jurusan</label>
        <input type="text" name="nama_jurusan" value="{{ $jurusan->nama_jurusan }}" class="w-full border p-2 rounded mb-4" required>
        <div class="flex gap-2">
            <a href="{{ route('jurusan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>

@endsection
