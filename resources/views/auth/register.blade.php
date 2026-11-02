<x-layouts.app title="Daftar">
    <section class="min-h-[calc(100vh-64px)] flex items-center justify-center py-12 px-4 gradient-hero-soft">
        <div class="w-full max-w-5xl grid lg:grid-cols-2 gap-0 bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Left: Branding --}}
            <div class="hidden lg:flex flex-col justify-center p-12 gradient-hero text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 32px 32px;"></div>
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-secondary-400/10 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-14 h-14 rounded-xl bg-white flex items-center justify-center shadow-md">
                            <img src="{{ asset('images/logo-kominfo.png') }}" alt="Logo Kominfo" class="w-full h-full object-contain p-1">
                        </div>
                        <div>
                            <span class="text-xl font-bold">Lapor</span><span class="text-xl font-bold text-secondary-300">Kominfo</span>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold mb-4">Bergabunglah!</h2>
                    <p class="text-blue-100/80 leading-relaxed mb-8">Daftar akun untuk memantau laporan dan berkontribusi pada layanan digital yang lebih baik di Sumba Barat Daya.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                            <p class="text-2xl font-bold text-white">100%</p>
                            <p class="text-xs text-blue-200/70 mt-1">Gratis & Transparan</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                            <p class="text-2xl font-bold text-white">24/7</p>
                            <p class="text-xs text-blue-200/70 mt-1">Akses Kapan Saja</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Form --}}
            <div class="p-8 sm:p-12 flex flex-col justify-center">
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <div class="w-9 h-9 rounded-lg overflow-hidden flex items-center justify-center shadow-md bg-white">
                        <img src="{{ asset('images/logo-kominfo.png') }}" alt="Logo Kominfo" class="w-full h-full object-contain p-0.5">
                    </div>
                    <span class="text-lg font-bold text-primary-800">Lapor</span><span class="text-lg font-bold text-secondary-600">Kominfo</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Buat Akun</h2>
                <p class="text-sm text-gray-500 mb-8">Isi data diri Anda untuk mendaftar.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5" id="register-form">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all duration-200 outline-none"
                               placeholder="Nama lengkap Anda">
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all duration-200 outline-none"
                               placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all duration-200 outline-none"
                               placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all duration-200 outline-none"
                               placeholder="Ulangi kata sandi">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full py-3.5 px-6 gradient-hero text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 text-sm" id="btn-register">
                        Daftar
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 mt-8">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Masuk</a>
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>
