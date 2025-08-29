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
    <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m7-7 7 7M13 5v6h6M5 10v10h3m10-11l2 2m-2-2v10h-3m-6 0h6" />
        </svg>
        Dashboard
    </a>

    <!-- Civitas Akademika -->
    @php
        $isCivitasOpen = Route::is('pegawai.*') || Route::is('siswa.*');
    @endphp
    <div x-data="{ open: localStorage.getItem('dropdown-civitas') === 'true' || {{ $isCivitasOpen ? 'true' : 'false' }} }"
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
    @php
        $isAbsensiOpen = Route::is('admin.absensi.guru') || Route::is('admin.absensi.tendik') || Route::is('admin.absensi.siswa');
    @endphp
    <div x-data="{ open: localStorage.getItem('dropdown-absensi') === 'true' || {{ $isAbsensiOpen ? 'true' : 'false' }} }"
         x-init="$watch('open', value => localStorage.setItem('dropdown-absensi', value))"
         class="text-white">
        <button @click="open = !open" class="w-full flex items-center gap-2 px-3 py-2 text-white font-medium rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 21h14V7H5v14z" />
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

    <!-- Pengaturan -->
    <a href="{{ route('superadmin.settings.index') }}" class="flex items-center gap-2 text-base font-medium text-white px-3 py-2 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
            </svg>
            Keluar
        </button>
    </form>

</div>
@endsection
