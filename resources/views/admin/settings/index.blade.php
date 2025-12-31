@extends('layouts.app')
@section('title', 'Admin setting - smkhijaumuda')
@include('components.sidebar-admin')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan</h1>

            <!-- Link ke profil admin -->
            <div class="mb-2">
                <h2>
                    <a href="{{ route('admin.profile.index') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Profil
                    </a>
                </h2>
            </div>
            <div class="mb-2">
                <h2>
                    <a href="{{ route('admin.ubahsandi') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Ubah Kata Sandi
                    </a>
                </h2>
            </div>
            <div class="mb-2">
                <h2>
                    <a href="{{ route('kelas.index') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Kelas
                    </a>
                </h2>
            </div>
            <div class="mb-2">
                <h2>
                    <a href="{{ route('jurusan.index') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Jurusan
                    </a>
                </h2>
            </div>

            <!-- ✅ Menu baru: Mata Pelajaran -->
            {{-- <div class="mb-2">
                <h2>
                    <a href="{{ route('mapel.index') }}" class="text-gray-600 hover:underline text-lg font-semibold">
                        Mata Pelajaran
                    </a>
                </h2>
            </div> --}}

            {{-- <div class="mb-2">
                <h2>
                    <button 
                        id="openRadiusModal" 
                        class="text-gray-600 hover:underline text-lg font-semibold focus:outline-none">
                        Radius Ujian
                    </button>
                </h2>
                            <!-- Modal Radius -->
            <div id="radiusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-96 relative">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Atur Radius Ujian</h2>
                    <form id="radiusForm" method="POST" action="{{ route('admin.radius.update') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="radius" class="block text-gray-700 mb-1">Radius (meter)</label>
                            <input 
                            type="number" 
                            name="radius" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            value="{{ old('radius', $radius) }}" 
                            min="10" 
                            max="10000" 
                            required
                        >
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" id="closeRadiusModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
 --}}


    
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle (kode kamu sebelumnya)
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

        // Modal radius
        const openBtn = document.getElementById('openRadiusModal');
        const modal = document.getElementById('radiusModal');
        const closeBtn = document.getElementById('closeRadiusModal');

        if (openBtn && modal && closeBtn) {
            openBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            closeBtn.addEventListener('click', () => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });

            // Tutup modal jika klik di luar box
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush
