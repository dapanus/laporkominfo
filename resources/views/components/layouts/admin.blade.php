<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' : '' }}Admin LaporKominfo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800" x-data="{ sidebarOpen: true, mobileSidebar: false }">
        <div class="min-h-screen flex">
            {{-- ===== SIDEBAR ===== --}}
            {{-- Desktop Sidebar --}}
            <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
                   class="hidden lg:flex flex-col bg-gray-900 text-gray-300 transition-all duration-300 fixed inset-y-0 left-0 z-30"
                   id="admin-sidebar">
                {{-- Logo --}}
                <div class="h-16 flex items-center px-4 border-b border-gray-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg gradient-hero flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div x-show="sidebarOpen" x-transition class="overflow-hidden">
                            <span class="text-base font-bold text-white">Lapor</span><span class="text-base font-bold text-secondary-400">Kominfo</span>
                            <p class="text-[10px] text-gray-500 -mt-0.5">Panel Admin</p>
                        </div>
                    </a>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span x-show="sidebarOpen">Dashboard</span>
                    </a>

                    <div x-show="sidebarOpen" class="pt-4 pb-2 px-3">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Laporan</p>
                    </div>

                    <a href="{{ route('admin.laporan.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span x-show="sidebarOpen">Semua Laporan</span>
                    </a>

                    <a href="{{ route('admin.laporan.index', ['jenis' => 'pengaduan']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors text-gray-400 hover:bg-gray-800 hover:text-white">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <span x-show="sidebarOpen">Pengaduan</span>
                    </a>

                    <a href="{{ route('admin.laporan.index', ['jenis' => 'aspirasi']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors text-gray-400 hover:bg-gray-800 hover:text-white">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <span x-show="sidebarOpen">Aspirasi</span>
                    </a>
                </nav>

                {{-- Sidebar Bottom --}}
                <div class="border-t border-gray-800 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full gradient-hero flex items-center justify-center text-white text-xs font-bold shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div x-show="sidebarOpen" class="overflow-hidden">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">Admin</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen" class="mt-3">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-400 transition-colors w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Mobile Sidebar Overlay --}}
            <div x-show="mobileSidebar" x-transition:enter="transition-opacity ease-out duration-300" x-transition:leave="transition-opacity ease-in duration-200" @click="mobileSidebar = false" class="lg:hidden fixed inset-0 bg-black/50 z-40" style="display:none;"></div>

            {{-- Mobile Sidebar --}}
            <aside x-show="mobileSidebar" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="lg:hidden fixed inset-y-0 left-0 w-64 bg-gray-900 text-gray-300 z-50" style="display:none;">
                {{-- Same content as desktop sidebar, always expanded --}}
                <div class="h-16 flex items-center justify-between px-4 border-b border-gray-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg gradient-hero flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <span class="text-base font-bold text-white">Admin</span>
                    </a>
                    <button @click="mobileSidebar = false" class="text-gray-500 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="py-4 px-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.laporan.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Semua Laporan
                    </a>
                </nav>
            </aside>

            {{-- ===== MAIN CONTENT ===== --}}
            <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="flex-1 transition-all duration-300">
                {{-- Top Bar --}}
                <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-20">
                    <div class="flex items-center gap-4">
                        {{-- Toggle Sidebar (Desktop) --}}
                        <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:inline-flex p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        {{-- Toggle Sidebar (Mobile) --}}
                        <button @click="mobileSidebar = true" class="lg:hidden p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>

                        @isset($header)
                        <h1 class="text-lg font-semibold text-gray-800">{{ $header }}</h1>
                        @endisset
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="/" target="_blank" class="text-sm text-gray-500 hover:text-primary-600 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Lihat Situs
                        </a>
                    </div>
                </header>

                {{-- Flash Messages --}}
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="mx-4 lg:mx-8 mt-4">
                    <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                        <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                </div>
                @endif

                {{-- Page Content --}}
                <main class="p-4 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
