<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistem Pelaporan Pengaduan & Aspirasi Masyarakat - Diskominfo Kab. Sumba Barat Daya">

        <title>{{ isset($title) ? $title . ' — ' : '' }}LaporKominfo SBD</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface text-gray-800">
        {{-- ===== NAVBAR ===== --}}
        <nav x-data="{ open: false, scrolled: false }"
             x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
             :class="scrolled ? 'bg-white/90 backdrop-blur-lg shadow-sm' : 'bg-white'"
             class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-gray-100/80"
             id="main-navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    {{-- Logo --}}
                    <a href="/" class="flex items-center gap-3 group" id="nav-logo">
                        <div class="w-9 h-9 rounded-lg overflow-hidden flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow bg-white">
                            <img src="{{ asset('images/logo-kominfo.png') }}" alt="Logo Kominfo" class="w-full h-full object-contain p-0.5">
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-lg font-bold text-primary-800">Lapor</span><span class="text-lg font-bold text-secondary-600">Kominfo</span>
                            <p class="text-[10px] text-gray-400 -mt-1 leading-tight">Kab. Sumba Barat Daya</p>
                        </div>
                    </a>

                    {{-- Desktop Nav Links --}}
                    <div class="hidden md:flex items-center gap-1">
                        <a href="/" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->is('/') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-primary-700 hover:bg-gray-50' }}" id="nav-beranda">
                            Beranda
                        </a>
                        <a href="{{ route('laporan.create') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('laporan.create') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-primary-700 hover:bg-gray-50' }}" id="nav-buat-laporan">
                            Buat Laporan
                        </a>
                        <a href="{{ route('laporan.search') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('laporan.search') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-primary-700 hover:bg-gray-50' }}" id="nav-cari-laporan">
                            Cari Laporan
                        </a>
                        @auth
                        <a href="{{ route('laporan.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('laporan.index') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-primary-700 hover:bg-gray-50' }}" id="nav-laporan-saya">
                            Laporan Saya
                        </a>
                        @endauth
                    </div>

                    {{-- Right Side --}}
                    <div class="flex items-center gap-3">
                        @auth
                            <div x-data="{ dropOpen: false }" class="relative hidden md:block">
                                <button @click="dropOpen = !dropOpen" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 transition-colors" id="user-menu-btn">
                                    <div class="w-8 h-8 rounded-full gradient-hero flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 transition-transform" :class="dropOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="dropOpen" @click.away="dropOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50" style="display:none;">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profil Saya
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="hidden md:inline-flex px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary-700 transition-colors" id="nav-login">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="hidden md:inline-flex px-5 py-2.5 text-sm font-semibold text-white rounded-lg gradient-hero shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5" id="nav-register">
                                Daftar
                            </a>
                        @endauth

                        {{-- Mobile Hamburger --}}
                        <button @click="open = !open" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors" id="mobile-menu-btn">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden bg-white border-t border-gray-100" style="display:none;">
                <div class="px-4 py-3 space-y-1">
                    <a href="/" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->is('/') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:bg-gray-50' }}">Beranda</a>
                    <a href="{{ route('laporan.create') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('laporan.create') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:bg-gray-50' }}">Buat Laporan</a>
                    <a href="{{ route('laporan.search') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('laporan.search') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:bg-gray-50' }}">Cari Laporan</a>
                    @auth
                    <a href="{{ route('laporan.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('laporan.index') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:bg-gray-50' }}">Laporan Saya</a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg">Keluar</button>
                    </form>
                    @else
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm font-semibold text-center text-white rounded-lg gradient-hero">Daftar</a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="fixed top-20 right-4 z-50 max-w-sm">
            <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl shadow-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="fixed top-20 right-4 z-50 max-w-sm">
            <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl shadow-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
                <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
        </div>
        @endif

        {{-- Page Content --}}
        <main class="pt-16">
            {{ $slot }}
        </main>

        {{-- ===== FOOTER ===== --}}
        <footer class="bg-gray-900 text-gray-300 mt-auto" id="footer">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Brand --}}
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-lg gradient-hero flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-lg font-bold text-white">Lapor</span><span class="text-lg font-bold text-secondary-400">Kominfo</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed">Sistem pelaporan pengaduan dan aspirasi masyarakat Dinas Komunikasi dan Informatika Kabupaten Sumba Barat Daya.</p>
                    </div>

                    {{-- Links --}}
                    <div>
                        <h4 class="text-white font-semibold mb-4">Tautan</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                            <li><a href="{{ route('laporan.create') }}" class="hover:text-white transition-colors">Buat Laporan</a></li>
                            <li><a href="{{ route('laporan.search') }}" class="hover:text-white transition-colors">Cari Laporan</a></li>
                        </ul>
                    </div>

                    {{-- Contact --}}
                    <div>
                        <h4 class="text-white font-semibold mb-4">Kontak</h4>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Tambolaka, Sumba Barat Daya, NTT
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                diskominfo@sumbabarat daya.go.id
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} Diskominfo Kab. Sumba Barat Daya. Hak cipta dilindungi.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
