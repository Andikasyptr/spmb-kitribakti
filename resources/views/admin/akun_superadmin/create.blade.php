@extends('layouts.app')
@section('title', 'Tambah Akun Super Admin - smkhijaumuda')
@include('components.sidebar-admin')

@section('content')
<div class="py-6">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-xl font-bold text-gray-800 mb-4">Tambah Akun Super Admin</h1>

            <form action="{{ route('admin.super-admin.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

               <div class="mb-4 relative">
    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
    <div class="relative">
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm pr-10">
        <button type="button" onclick="togglePassword('password', this)"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12c2.25-4.5 6.75-7.5 9.75-7.5S19.5 7.5 21.75 12c-2.25 4.5-6.75 7.5-9.75 7.5S4.5 16.5 2.25 12z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </button>
    </div>
    @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4 relative">
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
    <div class="relative">
        <input type="password" name="password_confirmation" id="password_confirmation" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm pr-10">
        <button type="button" onclick="togglePassword('password_confirmation', this)"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12c2.25-4.5 6.75-7.5 9.75-7.5S19.5 7.5 21.75 12c-2.25 4.5-6.75 7.5-9.75 7.5S4.5 16.5 2.25 12z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </button>
    </div>
</div>

<script>
function togglePassword(fieldId, button) {
    const input = document.getElementById(fieldId);
    const icon = button.querySelector('svg');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.innerHTML = isHidden
        ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88A3 3 0 0012 15a3 3 0 002.12-.88M6.12 6.12C4.33 7.86 3 9.86 3 12c2.25 4.5 6.75 7.5 9.75 7.5 1.27 0 2.53-.3 3.75-.87m3.38-2.63C20.28 14.14 21 13 21 12c-2.25-4.5-6.75-7.5-9.75-7.5-1.27 0-2.53.3-3.75.87"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c2.25-4.5 6.75-7.5 9.75-7.5S19.5 7.5 21.75 12c-2.25 4.5-6.75 7.5-9.75 7.5S4.5 16.5 2.25 12z"/><circle cx="12" cy="12" r="3"/>`;
}
</script>


                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg shadow transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
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