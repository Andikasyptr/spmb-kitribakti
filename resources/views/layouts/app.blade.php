<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
       <!-- Logo Tab Browser -->
    <link rel="icon" href="{{ asset('/images/hm.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <title>@yield('title', config('app.name'))</title>
    @yield('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex">

        {{-- Desktop Sidebar --}}
        @isset($noSidebar)
            {{-- Sidebar dihapus --}}
        @else
            <div class="hidden fixed lg:flex lg:flex-shrink-0">
                <div class="flex flex-col w-64 bg-gray-800 border-r border-gray-200 h-screen overflow-y-auto">
                    @yield('sidebar-content')
                </div>
            </div>
        @endisset

        {{-- Mobile Sidebar Backdrop --}}
        @isset($noSidebar)
            {{-- tidak ada backdrop --}}
        @else
            <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden hidden"></div>
        @endisset

        {{-- Mobile Sidebar --}}
        @isset($noSidebar)
            {{-- tidak ada mobile sidebar --}}
        @else
            <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden">
                <div class="flex-1 flex flex-col h-full overflow-y-auto">
                    @yield('sidebar-content')
                </div>
            </div>
        @endisset

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile Top Navigation -->
            <header class="lg:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200">
                <button id="mobile-menu-toggle" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="text-lg font-medium text-gray-800">
                    SMK Hijau Muda
                </div>
                <div class="w-6"></div> <!-- Spacer for alignment -->
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto focus:outline-none @isset($noSidebar) lg:ml-0 @else lg:ml-64 @endisset">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>