<x-layouts.app title="Masuk">
    <section class="min-h-[calc(100vh-64px)] flex items-center justify-center py-12 px-4 gradient-hero-soft">
        <div class="w-full max-w-5xl grid lg:grid-cols-2 gap-0 bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Left: Branding --}}
            <div class="hidden lg:flex flex-col justify-center p-12 gradient-hero text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 32px 32px;"></div>
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-14 h-14 rounded-xl bg-white flex items-center justify-center shadow-md">
                            <img src="{{ asset('images/logo-kominfo.png') }}" alt="Logo Kominfo" class="w-full h-full object-contain p-1">
                        </div>
                        <div>
                            <span class="text-xl font-bold">Lapor</span><span class="text-xl font-bold text-secondary-300">Kominfo</span>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold mb-4">Selamat Datang Kembali!</h2>
                    <p class="text-blue-100/80 leading-relaxed mb-8">Masuk untuk melacak laporan, melihat perkembangan, dan mendapatkan notifikasi terbaru.</p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-sm text-blue-100/70">
                            <svg class="w-5 h-5 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                            Tracking status laporan real-time
                        </div>
                        <div class="flex items-center gap-3 text-sm text-blue-100/70">
                            <svg class="w-5 h-5 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                            Riwayat semua laporan Anda
                        </div>
                        <div class="flex items-center gap-3 text-sm text-blue-100/70">
                            <svg class="w-5 h-5 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                            Notifikasi update laporan
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Form --}}
            <div class="p-8 sm:p-12 flex flex-col justify-center">
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <div class="w-9 h-9 rounded-lg overflow-hidden flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow bg-white">
                            <img src="{{ asset('images/logo-kominfo.png') }}" alt="Logo Kominfo" class="w-full h-full object-contain p-0.5">
                        </div>
                    <span class="text-lg font-bold text-primary-800">Lapor</span><span class="text-lg font-bold text-secondary-600">Kominfo</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Masuk</h2>
                <p class="text-sm text-gray-500 mb-8">Masukkan email dan kata sandi Anda untuk melanjutkan.</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5" id="login-form">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all duration-200 outline-none"
                               placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all duration-200 outline-none"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-600">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lupa sandi?</a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full py-3.5 px-6 gradient-hero text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 text-sm" id="btn-login">
                        Masuk
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 mt-8">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>
