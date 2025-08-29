@section('sidebar-content')
@php
    $profile = optional(auth()->user()->profileAdmin);
    $fotoPath = $profile->foto ?? null;
    $finalPath = null;

    if ($fotoPath) {
        $pathParts = pathinfo($fotoPath);
        $folder = $pathParts['dirname'];
        $filename = $pathParts['basename'];
        $encodedFilename = rawurlencode($filename);
        $finalPath = $folder . '/' . $encodedFilename;
    }
@endphp

<!-- Profil -->
<div class="px-4 pt-12 pb-3 flex items-center">
    <div class="flex-shrink-0">
        <img class="h-8 w-8 rounded-full" 
            src="{{ $fotoPath 
                ? asset('storage/' . $finalPath) 
                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}" 
            alt="User profile">
    </div>
    <div class="ml-3">
        <p class="text-base font-medium text-white">{{ auth()->user()->name }}</p>
        <p class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</p>
    </div>
</div>

<!-- Menu Navigasi -->
<div class="mt-6 px-2 space-y-1">

    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
        </svg>
        Dashboard
    </a>
    <!-- E-Learning -->
    <a href="{{ route('admin.exams.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <!-- Ikon buku -->
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 0a4 4 0 00-4 4v12a4 4 0 004 4m0-20a4 4 0 014 4v12a4 4 0 01-4 4" />
        </svg>
        E-Learning
    </a>

    <!-- Data Ujian Siswa -->
        <a href="{{ route('data-ujian-siswa.index') }}" 
        class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <!-- Ikon ujian -->
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-6h13M9 11h13M9 7h13M5 7h.01M5 11h.01M5 17h.01" />
            </svg>
            Data Ujian Siswa
        </a>



    <!-- Manajemen Akun -->
    <div x-data="{ open: localStorage.getItem('dropdown-manajemen') !== 'false' }"
         x-init="$watch('open', value => localStorage.setItem('dropdown-manajemen', value))"
         class="text-white">
        <button @click="open = !open" class="w-full flex items-center gap-2 px-3 py-2 text-white font-medium rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-4.586a1 1 0 00-.707.293l-1.414 1.414A1 1 0 0110.586 7H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6" />
            </svg>
            <span>Manajemen Akun</span>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="h-4 w-4 ml-auto transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-2 space-y-1 pl-6 text-sm">
            <a href="{{ route('admin.super-admin.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('admin.super-admin.*') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Super Admin
            </a>
            <a href="{{ route('admin.guru.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('admin.guru.*') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Guru
            </a>
            <a href="{{ route('admin.tendik.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('admin.tendik.*') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Tenaga Kependidikan
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('admin.siswa.*') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Siswa
            </a>
        </div>
    </div>

    <!-- Civitas Akademika -->
    <div x-data="{ open: localStorage.getItem('dropdown-civitas') !== 'false' }"
         x-init="$watch('open', value => localStorage.setItem('dropdown-civitas', value))"
         class="text-white">
        <button @click.stop="open = !open" class="w-full flex items-center gap-2 px-3 py-2 text-white font-medium rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m1-4a4 4 0 118 0 4 4 0 01-8 0z" />
            </svg>
            <span>Civitas Akademika</span>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="h-4 w-4 ml-auto transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-2 space-y-1 pl-6 text-sm">
            <a href="{{ route('pegawai.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('pegawai.*') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Data Kepegawaian
            </a>
            <a href="{{ route('datasiswa.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('siswa.*') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Data Siswa
            </a>
        </div>
    </div>

    <!-- Absensi -->
    <div x-data="{ open: localStorage.getItem('dropdown-absensi') !== 'false' }"
         x-init="$watch('open', value => localStorage.setItem('dropdown-absensi', value))"
         class="text-white">
        <button @click="open = !open" class="w-full flex items-center gap-2 px-3 py-2 text-white font-medium rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v11a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z" />
            </svg>
            <span>Absensi</span>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="h-4 w-4 ml-auto transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-2 space-y-1 pl-6 text-sm">
            <a href="{{ route('absensi.guru') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('admin.absensi.guru') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Guru
            </a>
            <a href="{{ route('absensi.tendik') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('admin.absensi.tendik') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Tenaga Kependidikan
            </a>
            <a href="{{ route('absensi.siswa') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('admin.absensi.siswa') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Siswa
            </a>
        </div>
    </div>

    <!-- Arsip Data -->
    <div x-data="{ open: localStorage.getItem('dropdown-arsip') !== 'false' }"
         x-init="$watch('open', value => localStorage.setItem('dropdown-arsip', value))"
         class="text-white">
        <button @click.stop="open = !open" class="w-full flex items-center gap-2 px-3 py-2 text-white font-medium rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h3l1-2h4l1 2h3a2 2 0 012 2v12a2 2 0 01-2 2z" />
            </svg>
            <span>Arsip Data</span>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="h-4 w-4 ml-auto transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-2 space-y-1 pl-6 text-sm">
            <a href="{{ route('datasiswa.move') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ Route::is('datasiswa.move') ? 'bg-gray-200 text-gray-900' : 'text-gray-400 hover:bg-gray-100 hover:text-gray-900' }}">
                Siswa Keluar
            </a>
        </div>
    </div>

    <!-- Pengaturan -->
    <a href="{{ route('admin.settings') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0..." />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Pengaturan
    </a>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0..." />
            </svg>
            Keluar
        </button>
    </form>

</div>
@endsection
