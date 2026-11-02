<x-layouts.app title="Beranda">

    {{-- ===== HERO SECTION ===== --}}
    <section class="relative overflow-hidden gradient-hero min-h-[600px] flex items-center" id="hero">
        {{-- Decorative elements --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] bg-secondary-400/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-400/5 rounded-full blur-3xl"></div>
            {{-- Grid pattern --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left: Text --}}
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm font-medium mb-6 animate-fade-in-up">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        Sistem Aktif — Diskominfo Kab. Sumba Barat Daya
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6 animate-fade-in-up delay-100">
                        Laporkan.<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary-300 to-secondary-100">Pantau.</span><br>
                        Selesaikan.
                    </h1>

                    <p class="text-lg text-blue-100/90 max-w-lg mx-auto lg:mx-0 mb-8 animate-fade-in-up delay-200">
                        Sampaikan pengaduan atau aspirasi Anda untuk layanan komunikasi dan informatika yang lebih baik di Sumba Barat Daya.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-in-up delay-300">
                        <a href="{{ route('laporan.create') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-primary-700 font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300" id="cta-buat-laporan">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Laporan
                        </a>
                        <a href="{{ route('laporan.search') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300" id="cta-cari-laporan">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari Laporan
                        </a>
                    </div>
                </div>

                {{-- Right: Floating cards illustration --}}
                <div class="hidden lg:block relative">
                    <div class="relative w-full h-[400px]">
                        @foreach($laporans as $index => $item)
                            @php
                                // Position and animation delays based on loop index
                                $cardClasses = [
                                    0 => 'absolute top-0 right-0 w-72 animate-fade-in-up delay-200',
                                    1 => 'absolute top-32 left-0 w-64 animate-fade-in-up delay-400',
                                    2 => 'absolute bottom-0 right-12 w-60 animate-fade-in-up delay-500'
                                ][$index] ?? 'hidden';

                                // Category mappings
                                $categoryName = [
                                    'infrastruktur_jaringan' => 'Infrastruktur Jaringan',
                                    'layanan_digital' => 'Layanan Digital',
                                    'hoaks' => 'Hoaks / Konten Negatif',
                                    'data_sistem' => 'Data & Sistem'
                                ][$item['kategori']] ?? $item['kategori'];

                                $categoryColorBg = [
                                    'infrastruktur_jaringan' => 'bg-blue-50',
                                    'layanan_digital' => 'bg-violet-50',
                                    'hoaks' => 'bg-red-50',
                                    'data_sistem' => 'bg-emerald-50'
                                ][$item['kategori']] ?? 'bg-gray-50';

                                $categoryColorText = [
                                    'infrastruktur_jaringan' => 'text-blue-600',
                                    'layanan_digital' => 'text-violet-600',
                                    'hoaks' => 'text-red-600',
                                    'data_sistem' => 'text-emerald-600'
                                ][$item['kategori']] ?? 'text-gray-600';

                                // Type header mappings
                                $typeHeader = [
                                    'pengaduan' => 'Pengaduan Baru',
                                    'aspirasi' => 'Aspirasi',
                                    'selesai' => 'Selesai'
                                ][$item['jenis_laporan']] ?? ucfirst($item['jenis_laporan']);

                                // Status mappings
                                $statusLabel = [
                                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                    'diverifikasi' => 'Diverifikasi',
                                    'diproses' => 'Diproses',
                                    'selesai' => 'Selesai ✓',
                                    'ditolak' => 'Ditolak'
                                ][$item['status']] ?? null;

                                $statusColorBg = [
                                    'menunggu_verifikasi' => 'bg-amber-100',
                                    'diverifikasi' => 'bg-blue-100',
                                    'diproses' => 'bg-indigo-100',
                                    'selesai' => 'bg-green-100',
                                    'ditolak' => 'bg-red-100'
                                ][$item['status']] ?? 'bg-gray-100';

                                $statusColorText = [
                                    'menunggu_verifikasi' => 'text-amber-700',
                                    'diverifikasi' => 'text-blue-700',
                                    'diproses' => 'text-indigo-700',
                                    'selesai' => 'text-green-700',
                                    'ditolak' => 'text-red-700'
                                ][$item['status']] ?? 'text-gray-700';

                                // URL link
                                $cardUrl = !$item['is_dummy'] 
                                    ? route('laporan.show', $item['id_laporan']) 
                                    : 'javascript:void(0)';
                            @endphp

                            <a href="{{ $cardUrl }}" class="{{ $cardClasses }} glass rounded-2xl p-5 shadow-xl hover-lift block text-left transition-all duration-300">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-xl {{ $categoryColorBg }} flex items-center justify-center">
                                        @if($item['kategori'] === 'infrastruktur_jaringan')
                                            <svg class="w-5 h-5 {{ $categoryColorText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.858 15.355-5.858 21.213 0"/></svg>
                                        @elseif($item['kategori'] === 'layanan_digital')
                                            <svg class="w-5 h-5 {{ $categoryColorText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        @elseif($item['kategori'] === 'hoaks')
                                            <svg class="w-5 h-5 {{ $categoryColorText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        @else
                                            {{-- Data & Sistem --}}
                                            <svg class="w-5 h-5 {{ $categoryColorText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $typeHeader }}</p>
                                        <p class="text-xs text-gray-500">{{ $categoryName }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ \Illuminate\Support\Str::limit($item['deskripsi'], 80) }}</p>
                                
                                @if($statusLabel || $item['time'])
                                    <div class="mt-3 flex items-center justify-between">
                                        @if($statusLabel)
                                            <span class="text-[10px] font-semibold px-2.5 py-1 {{ $statusColorBg }} {{ $statusColorText }} rounded-full">{{ $statusLabel }}</span>
                                        @else
                                            <span></span>
                                        @endif
                                        @if($item['time'])
                                            <span class="text-[10px] text-gray-400">{{ $item['time'] }}</span>
                                        @endif
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave bottom --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F8FAFC"/>
            </svg>
        </div>
    </section>

    {{-- ===== CARA KERJA ===== --}}
    <section class="py-20 bg-surface" id="cara-kerja">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-xs font-semibold uppercase tracking-wider mb-4">Cara Kerja</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Mudah & Transparan</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Empat langkah sederhana untuk menyampaikan laporan Anda ke Diskominfo Kab. Sumba Barat Daya.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Step 1 --}}
                <div class="relative group">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover-lift text-center">
                        <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-100 transition-colors">
                            <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 rounded-full gradient-hero text-white text-xs font-bold flex items-center justify-center shadow-md">1</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pilih Jenis</h3>
                        <p class="text-sm text-gray-500">Pengaduan untuk masalah mendesak, atau Aspirasi untuk ide & usulan.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="relative group">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover-lift text-center">
                        <div class="w-14 h-14 rounded-2xl bg-secondary-50 flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary-100 transition-colors">
                            <svg class="w-7 h-7 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 rounded-full gradient-hero text-white text-xs font-bold flex items-center justify-center shadow-md">2</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Isi Laporan</h3>
                        <p class="text-sm text-gray-500">Lengkapi detail laporan, kategori, lokasi, dan lampirkan bukti foto.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="relative group">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover-lift text-center">
                        <div class="w-14 h-14 rounded-2xl bg-violet-50 flex items-center justify-center mx-auto mb-4 group-hover:bg-violet-100 transition-colors">
                            <svg class="w-7 h-7 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 rounded-full gradient-hero text-white text-xs font-bold flex items-center justify-center shadow-md">3</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Verifikasi</h3>
                        <p class="text-sm text-gray-500">Tim Diskominfo memverifikasi dan memproses laporan Anda.</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="relative group">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover-lift text-center">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-4 group-hover:bg-green-100 transition-colors">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 rounded-full gradient-hero text-white text-xs font-bold flex items-center justify-center shadow-md">4</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Selesai</h3>
                        <p class="text-sm text-gray-500">Pantau progres & dapatkan hasil tindak lanjut dari laporan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== KATEGORI ===== --}}
    <section class="py-20 bg-white" id="kategori">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-secondary-50 text-secondary-700 text-xs font-semibold uppercase tracking-wider mb-4">Kategori</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Lingkup Layanan Diskominfo</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Sampaikan laporan sesuai dengan bidang tugas Dinas Komunikasi dan Informatika.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Infrastruktur Jaringan --}}
                <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover-lift cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.858 15.355-5.858 21.213 0"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Infrastruktur Jaringan</h3>
                    <p class="text-sm text-gray-500">Internet, BTS, WiFi publik, konektivitas jaringan daerah.</p>
                </div>

                {{-- Layanan Digital --}}
                <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover-lift cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-violet-50 flex items-center justify-center mb-4 group-hover:bg-violet-100 transition-colors">
                        <svg class="w-7 h-7 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Layanan Digital Pemerintah</h3>
                    <p class="text-sm text-gray-500">Website, aplikasi, layanan online pemerintah yang bermasalah.</p>
                </div>

                {{-- Hoaks --}}
                <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover-lift cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mb-4 group-hover:bg-red-100 transition-colors">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Hoaks / Konten Negatif</h3>
                    <p class="text-sm text-gray-500">Pelaporan berita bohong, konten negatif, atau informasi menyesatkan.</p>
                </div>

                {{-- Data & Sistem --}}
                <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover-lift cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center mb-4 group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Data & Sistem Digital</h3>
                    <p class="text-sm text-gray-500">Error data, sistem informasi bermasalah, integrasi data.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA SECTION ===== --}}
    <section class="py-20 bg-surface" id="cta-section">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white rounded-3xl p-10 sm:p-16 shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-primary-50 to-transparent rounded-bl-full"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-secondary-50 to-transparent rounded-tr-full"></div>

                <div class="relative">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Punya Laporan?</h2>
                    <p class="text-gray-500 max-w-lg mx-auto mb-8">Suara Anda penting untuk pembangunan layanan komunikasi dan informatika yang lebih baik di Sumba Barat Daya.</p>
                    <a href="{{ route('laporan.create') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 font-semibold text-white rounded-xl gradient-hero shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Buat Laporan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
