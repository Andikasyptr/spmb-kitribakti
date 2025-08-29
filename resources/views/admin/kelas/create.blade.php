@extends('layouts.app')

@section('title', 'Tambah Kelas')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-xl mx-auto bg-white rounded shadow p-6">
        <h1 class="text-xl font-semibold text-gray-700 mb-4">Tambah Kelas</h1>

        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('kelas.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded hover:bg-gray-300 transition">
                    Batal
                </a>
    
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>

        </form>
    </div>
</div>
@endsection
