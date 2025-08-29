@extends('layouts.app')
@section('title', 'Edit Siswa - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-xl mx-auto bg-white shadow rounded p-6">
        <h1 class="text-lg font-bold mb-4">Edit Akun Siswa</h1>

        <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm">Nama</label>
                <input type="text" name="name" value="{{ $siswa->name }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm">Email</label>
                <input type="email" name="email" value="{{ $siswa->email }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end">
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Perbarui</button>
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