<x-layouts.app title="Cari Laporan">
    <section class="py-16 bg-surface min-h-[calc(100vh-64px)]">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Cari Laporan</h1>
                <p class="text-gray-500">Masukkan ID laporan untuk melihat status dan detail.</p>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <form method="GET" action="{{ route('laporan.search') }}" class="flex gap-3" id="search-form">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Masukkan ID atau kata kunci laporan..."
                           class="flex-1 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all outline-none">
                    <button type="submit" class="px-6 py-3 gradient-hero text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all text-sm">
                        Cari
                    </button>
                </form>

                @if(request('q'))
                    <div class="mt-8">
                        @if(isset($laporan) && $laporan->count() > 0)
                            <p class="text-sm text-gray-500 mb-4">Ditemukan <strong>{{ $laporan->count() }}</strong> hasil:</p>
                            <div class="space-y-3">
                                @foreach($laporan as $item)
                                    <a href="{{ route('laporan.show', $item) }}" class="block bg-gray-50 hover:bg-primary-50/50 rounded-xl p-4 border border-gray-100 transition-colors group">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 group-hover:text-primary-700 truncate">{{ $item->judul }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $item->id_laporan }} · {{ $item->created_at->format('d M Y') }}</p>
                                            </div>
                                            <span class="shrink-0 text-xs font-semibold px-2.5 py-1 rounded-full
                                                {{ $item->status === 'menunggu_verifikasi' ? 'bg-amber-100 text-amber-700' : '' }}
                                                {{ $item->status === 'diverifikasi' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $item->status === 'diproses' ? 'bg-violet-100 text-violet-700' : '' }}
                                                {{ $item->status === 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $item->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                                            ">{{ str_replace('_', ' ', ucfirst($item->status)) }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-gray-500 text-sm">Laporan tidak ditemukan.</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
