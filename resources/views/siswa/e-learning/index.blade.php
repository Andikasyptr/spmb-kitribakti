@extends('layouts.app')
@section('title', 'E-learning - smkhijaumuda')

@include('components.sidebar-siswa')

@section('content')
{{-- Wrapper dikasih ID biar bisa diblur --}}
<div id="elearning-content" class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📚 E-Learning</h1>
    </div>

    <!-- Menu Ujian Saja -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Menu Ujian -->
        <a href="{{ route('siswa.ujian.index') }}" 
           class="flex items-center p-4 bg-white shadow rounded-lg hover:shadow-lg transition">
            <div class="flex-shrink-0 p-3 bg-red-100 text-red-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 8v4l3 3m6 5H3V5h18v14z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-lg font-semibold">Ujian</p>
                <p class="text-sm text-gray-500">Kerjakan ujian online</p>
            </div>
        </a>
    </div>
</div>

{{-- Modal Wajib Lengkapi Profil --}}
@if (!auth()->user()->siswa)
    <style>
        body {
            overflow: hidden; /* biar tidak bisa discroll */
        }
        #elearning-content {
            filter: blur(6px);
            pointer-events: none; /* blok interaksi */
            user-select: none;
            transition: filter 0.3s ease;
        }
    </style>

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-transparent backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-600 max-w-lg p-6 relative z-50">
            <div class="flex items-center space-x-3">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Lengkapi Data Diri</h3>
            </div>
            <p class="mt-4 text-sm text-gray-600">
                Anda wajib melengkapi data diri terlebih dahulu untuk bisa mengakses fitur e-learning.
            </p>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('spmb.form') }}"
                   class="inline-flex justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                    Lengkapi Profil
                </a>
            </div>
        </div>
    </div>
@endif
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
