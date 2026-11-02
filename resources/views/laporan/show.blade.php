<x-layouts.app :title="$laporan->judul ?? 'Detail Laporan'">
    <section class="py-12 bg-surface min-h-[calc(100vh-64px)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back --}}
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary-600 transition-colors mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>

            <div class="grid lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Header Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $laporan->jenis_laporan === 'pengaduan' ? 'bg-amber-100 text-amber-700' : 'bg-secondary-100 text-secondary-700' }}">
                                {{ ucfirst($laporan->jenis_laporan) }}
                            </span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $laporan->status === 'menunggu_verifikasi' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $laporan->status === 'diverifikasi' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $laporan->status === 'diproses' ? 'bg-violet-100 text-violet-700' : '' }}
                                {{ $laporan->status === 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $laporan->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                            ">{{ str_replace('_', ' ', ucfirst($laporan->status)) }}</span>
                            <span class="text-xs text-gray-400">{{ $laporan->id_laporan }}</span>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $laporan->judul }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $laporan->created_at->format('d M Y, H:i') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                {{ str_replace('_', ' ', ucfirst($laporan->kategori)) }}
                            </span>
                            @if($laporan->kecamatan)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $laporan->desa }}, {{ $laporan->kecamatan }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <h2 class="text-sm font-semibold text-gray-900 mb-3">Deskripsi</h2>
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $laporan->deskripsi }}</p>
                    </div>

                    {{-- Photos --}}
                    @if($laporan->foto && count($laporan->foto) > 0)
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <h2 class="text-sm font-semibold text-gray-900 mb-3">Foto Bukti</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($laporan->foto as $foto)
                                <div class="aspect-square rounded-xl overflow-hidden border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity">
                                    <img src="{{ Storage::url($foto) }}" alt="Bukti foto" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Admin Notes --}}
                    @if($laporan->catatan_admin)
                    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                        <h2 class="text-sm font-semibold text-blue-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                            Catatan Admin
                        </h2>
                        <p class="text-sm text-blue-800 leading-relaxed">{{ $laporan->catatan_admin }}</p>
                    </div>
                    @endif
                </div>

                {{-- Sidebar: Timeline --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm sticky top-24">
                        <h2 class="text-sm font-semibold text-gray-900 mb-5">Status Tracking</h2>
                        @php
                            $statusOrder = ['menunggu_verifikasi', 'diverifikasi', 'diproses', 'selesai'];
                            $currentIndex = array_search($laporan->status, $statusOrder);
                            if ($laporan->status === 'ditolak') $currentIndex = 1;
                            $statusLabels = [
                                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                'diverifikasi' => 'Diverifikasi',
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                            ];
                            $statusIcons = ['📝', '✅', '🔄', '🎉'];
                        @endphp

                        <div class="space-y-0">
                            @foreach($statusOrder as $i => $st)
                                <div class="flex gap-3">
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm shrink-0
                                            {{ $i <= $currentIndex && $laporan->status !== 'ditolak' ? 'gradient-hero text-white shadow-md' : ($laporan->status === 'ditolak' && $i === 1 ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-400') }}">
                                            @if($laporan->status === 'ditolak' && $i === 1)
                                                ✕
                                            @elseif($i <= $currentIndex && $laporan->status !== 'ditolak')
                                                ✓
                                            @else
                                                {{ $i + 1 }}
                                            @endif
                                        </div>
                                        @if(!$loop->last)
                                            <div class="w-0.5 h-8 {{ $i < $currentIndex && $laporan->status !== 'ditolak' ? 'bg-primary-300' : 'bg-gray-100' }}"></div>
                                        @endif
                                    </div>
                                    <div class="pb-6">
                                        <p class="text-sm font-medium {{ $i <= $currentIndex ? 'text-gray-900' : 'text-gray-400' }}">
                                            @if($laporan->status === 'ditolak' && $i === 1)
                                                Ditolak
                                            @else
                                                {{ $statusLabels[$st] }}
                                            @endif
                                        </p>
                                        @if($i === 0)
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
