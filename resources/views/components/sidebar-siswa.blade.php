@section('sidebar-content')
@php
    $siswa = auth()->user()->siswa; // Ambil data relasi siswa
    $fotoPath = $siswa->file_foto ?? null;
    $finalPath = null;

    if ($fotoPath) {
        $pathParts = pathinfo($fotoPath);
        $folder = $pathParts['dirname'];
        $filename = $pathParts['basename'];
        $encodedFilename = rawurlencode($filename);
        $finalPath = $folder . '/' . $encodedFilename;
    }
@endphp

<!-- Profil Siswa -->
<div class="px-4 pt-12 pb-3 flex items-center">
    <div class="flex-shrink-0">
        <a href="{{ route('profile.siswa') }}">
            <img class="h-10 w-10 rounded-full object-cover border cursor-pointer hover:opacity-80 transition"
                 style="max-width:40px; max-height:40px;"
                 src="{{ $fotoPath 
                     ? asset('storage/' . $finalPath) 
                     : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}"
                 alt="User profile">
        </a>
    </div>
    <div class="ml-3 w-40">
        <p class="text-base font-medium text-white truncate">{{ auth()->user()->name }}</p>
        <p class="text-sm font-medium text-gray-400 truncate">{{ auth()->user()->email }}</p>
    </div>
</div>


<!-- Menu Navigasi Siswa -->
<div class="mt-6 px-2 space-y-1">

    <!-- Dashboard -->
    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition {{ Route::is('siswa.dashboard') ? 'bg-gray-100 text-gray-900' : '' }}">
        <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m7-7l7 7M13 5v6h6M5 10v10h3" />
        </svg>
        Dashboard
    </a>

     <!-- E-Learning -->
    <a href="{{ route ('siswa.e-learning.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <!-- Ikon buku -->
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 0a4 4 0 00-4 4v12a4 4 0 004 4m0-20a4 4 0 014 4v12a4 4 0 01-4 4" />
        </svg>
        E-Learning
    </a>


    <!-- Absensi -->
    <a href="{{ route ('siswa.absensi.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition {{ Route::is('siswa.absensi') ? 'bg-gray-100 text-gray-900' : '' }}">
        <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 21h14V7H5v14z" />
        </svg>
        Absensi
    </a>

    <!-- Nilai -->
    <a href="#" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition {{ Route::is('siswa.nilai') ? 'bg-gray-100 text-gray-900' : '' }}">
        <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4M9 23v-6h6v6" />
        </svg>
        Nilai
    </a>

    <!-- Belajar Mengajar -->
    <a href="#" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition {{ Route::is('siswa.mata_pelajaran') ? 'bg-gray-100 text-gray-900' : '' }}">
        <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z" />
        </svg>
        Belajar Mengajar
    </a>
    {{-- profile --}}
      <a href="{{ route('profile.siswa') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <!-- Ikon user -->
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5.121 17.804A9.969 9.969 0 0112 15c2.42 0 4.63.86 6.313 2.29M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    Profil
</a>


 <!-- Pengaturan -->
    <a href="{{ route ('siswa.settings') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0a1.724 1.724 0 002.591.971c.811-.472 1.822.39 1.518 1.26a1.724 1.724 0 00.805 2.018c.875.509.875 1.781 0 2.29a1.724 1.724 0 00-.805 2.018c.304.87-.707 1.732-1.518 1.26a1.724 1.724 0 00-2.591.971c-.3.921-1.603.921-1.902 0a1.724 1.724 0 00-2.591-.971c-.811.472-1.822-.39-1.518-1.26a1.724 1.724 0 00-.805-2.018c-.875-.509-.875-1.781 0-2.29a1.724 1.724 0 00.805-2.018c-.304-.87.707-1.732 1.518-1.26.988.575 2.292-.05 2.591-.971z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Pengaturan
    </a>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
            </svg>
            Keluar
        </button>
    </form>

</div>
@endsection
