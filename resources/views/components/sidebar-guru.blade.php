@section('sidebar-content')
@php
    $pegawai = optional(auth()->user()->pegawai);
    $fotoPath = $pegawai->foto ?? null;
    $finalPath = null;

    if ($fotoPath) {
        $pathParts = pathinfo($fotoPath);
        $folder = $pathParts['dirname'];
        $filename = $pathParts['basename'];
        $encodedFilename = rawurlencode($filename);
        $finalPath = $folder . '/' . $encodedFilename;
    }
@endphp

<!-- Profil Guru -->
<div class="px-4 pt-12 pb-3 flex items-center">
    <div class="flex-shrink-0">
        <a href="{{ route('guru.profile.index') }}">
            <img class="h-9 w-9 rounded-full cursor-pointer transition duration-200 hover:scale-105 object-cover"
                style="max-width:36px; max-height:36px;"
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

<!-- Menu Navigasi Guru -->
<div class="mt-6 px-2 space-y-1">

    <!-- Dashboard -->
    <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition {{ Route::is('guru.dashboard') ? 'bg-gray-100 text-gray-900' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
        </svg>
        Dashboard
    </a>
    <!-- E-Learning -->
    <a href="{{ route ('guru.exams.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <!-- Ikon buku -->
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 0a4 4 0 00-4 4v12a4 4 0 004 4m0-20a4 4 0 014 4v12a4 4 0 01-4 4" />
        </svg>
        E-Learning
    </a>

    <!-- Data Ujian Siswa -->
        <a href="{{ route ('guru.data-ujian-siswa.index') }}" 
        class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <!-- Ikon ujian -->
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-6h13M9 11h13M9 7h13M5 7h.01M5 11h.01M5 17h.01" />
            </svg>
            Data Ujian Siswa
        </a>


    <!-- Absensi -->
    <a href="{{ route ('absensi.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition {{ Route::is('guru.absensi.*') ? 'bg-gray-100 text-gray-900' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-10 4h6m2 5a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h10z" />
        </svg>
        Absensi
    </a>

    <!-- Nilai (dropdown) -->
    <div x-data="{ open: localStorage.getItem('dropdown-nilai') !== 'false' }"
         x-init="$watch('open', value => localStorage.setItem('dropdown-nilai', value))"
         class="text-white">
        <button @click="open = !open" class="w-full flex items-center gap-2 px-3 py-2 font-medium rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-6 6v6m0 0H5a2 2 0 01-2-2v-2a2 2 0 012-2h4m6 6h4a2 2 0 002-2v-4a2 2 0 00-2-2h-4m0 0V9" />
            </svg>
            Nilai
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="h-4 w-4 ml-auto transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-2 space-y-1 pl-6 text-sm">
            <a href="#" class="block px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-900">Input Nilai</a>
            <a href="#" class="block px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-900">Lihat Nilai</a>
        </div>
    </div>

    <!-- Jadwal (dropdown) -->
    <div x-data="{ open: localStorage.getItem('dropdown-jadwal') !== 'false' }"
         x-init="$watch('open', value => localStorage.setItem('dropdown-jadwal', value))"
         class="text-white">
        <button @click="open = !open" class="w-full flex items-center gap-2 px-3 py-2 font-medium rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Belajar Mengajar
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="h-4 w-4 ml-auto transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-2 space-y-1 pl-6 text-sm">
            <a href="#" class="block px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-900">Jadwal Mengajar</a>
            <a href="#" class="block px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-900">Materi & Tugas</a>
        </div>
    </div>

    <!-- Profil -->
    <a href="{{ route('guru.profile.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5.121 17.804A9.969 9.969 0 0112 15c2.42 0 4.63.86 6.313 2.29M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Profil
    </a>

    <!-- Pengaturan -->
    <a href="{{ route('guru.settings') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0..." />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Pengaturan
    </a>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
            </svg>
            Keluar
        </button>
    </form>

</div>
@endsection
