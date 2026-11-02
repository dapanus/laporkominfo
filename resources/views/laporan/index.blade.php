<x-layouts.app title="Laporan Saya">
    <section class="py-12 bg-surface min-h-[calc(100vh-64px)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Laporan Saya</h1>
                    <p class="text-sm text-gray-500 mt-1">Daftar semua laporan yang pernah Anda buat.</p>
                </div>
                <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white gradient-hero rounded-xl shadow-md hover:shadow-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Laporan
                </a>
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap gap-2 mb-6" x-data="{ filter: '{{ request('status', 'semua') }}' }">
                @php $filters = ['semua' => 'Semua', 'menunggu_verifikasi' => 'Menunggu', 'diverifikasi' => 'Diverifikasi', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak']; @endphp
                @foreach($filters as $key => $label)
                    <a href="{{ route('laporan.index', ['status' => $key === 'semua' ? null : $key]) }}"
                       class="px-4 py-2 text-xs font-medium rounded-full border transition-colors {{ request('status', 'semua') === $key || (request('status') === null && $key === 'semua') ? 'bg-primary-600 text-white border-primary-600' : 'bg-white text-gray-600 border-gray-200 hover:border-primary-300 hover:text-primary-600' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Report List --}}
            @if(isset($laporans) && $laporans->count() > 0)
                <div class="space-y-4">
                    @foreach($laporans as $item)
                        <a href="{{ route('laporan.show', $item) }}" class="block bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover-lift transition-all group" id="laporan-{{ $item->id }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $item->jenis_laporan === 'pengaduan' ? 'bg-amber-100 text-amber-700' : 'bg-secondary-100 text-secondary-700' }}">
                                            {{ ucfirst($item->jenis_laporan) }}
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $item->id_laporan }}</span>
                                    </div>
                                    <h3 class="text-base font-semibold text-gray-900 group-hover:text-primary-700 transition-colors truncate">{{ $item->judul }}</h3>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $item->deskripsi }}</p>
                                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
                                        <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                                        <span>{{ str_replace('_', ' ', ucfirst($item->kategori)) }}</span>
                                    </div>
                                </div>
                                <span class="shrink-0 text-xs font-semibold px-3 py-1.5 rounded-full
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
                <div class="mt-8">{{ $laporans->links() }}</div>
            @else
                <div class="bg-white rounded-2xl p-12 border border-gray-100 text-center">
                    <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada laporan</h3>
                    <p class="text-sm text-gray-500 mb-6">Anda belum membuat laporan apapun.</p>
                    <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-white gradient-hero rounded-xl shadow-md hover:shadow-lg transition-all">
                        Buat Laporan Pertama
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
