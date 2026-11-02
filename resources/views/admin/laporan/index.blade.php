<x-layouts.admin :title="'Semua Laporan'" :header="'Semua Laporan'">
    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm mb-6">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap gap-3 items-end" id="admin-filter-form">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="ID atau judul laporan..."
                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
            </div>
            <div class="w-36">
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="">Semua</option>
                    <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diverifikasi" {{ request('status') === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="w-36">
                <label class="block text-xs font-medium text-gray-500 mb-1">Jenis</label>
                <select name="jenis" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="">Semua</option>
                    <option value="pengaduan" {{ request('jenis') === 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                    <option value="aspirasi" {{ request('jenis') === 'aspirasi' ? 'selected' : '' }}>Aspirasi</option>
                </select>
            </div>
            <div class="w-44">
                <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="">Semua</option>
                    <option value="infrastruktur_jaringan" {{ request('kategori') === 'infrastruktur_jaringan' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="layanan_digital" {{ request('kategori') === 'layanan_digital' ? 'selected' : '' }}>Layanan Digital</option>
                    <option value="hoaks" {{ request('kategori') === 'hoaks' ? 'selected' : '' }}>Hoaks</option>
                    <option value="data_sistem" {{ request('kategori') === 'data_sistem' ? 'selected' : '' }}>Data & Sistem</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 gradient-hero text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all">Filter</button>
            <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2.5 text-sm text-gray-500 hover:text-gray-700 transition-colors">Reset</a>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="admin-reports-table">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Judul</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Pelapor</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans ?? [] as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-xs font-mono text-gray-500">{{ $item->id_laporan }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 max-w-[200px] truncate">{{ $item->judul }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->user->name ?? 'Guest' }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $item->jenis_laporan === 'pengaduan' ? 'bg-amber-100 text-amber-700' : 'bg-secondary-100 text-secondary-700' }}">{{ ucfirst($item->jenis_laporan) }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">{{ str_replace('_', ' ', ucfirst($item->kategori)) }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                    {{ $item->status === 'menunggu_verifikasi' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $item->status === 'diverifikasi' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $item->status === 'diproses' ? 'bg-violet-100 text-violet-700' : '' }}
                                    {{ $item->status === 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $item->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                                ">{{ str_replace('_', ' ', ucfirst($item->status)) }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.laporan.show', $item) }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Detail →</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">Tidak ada laporan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($laporans) && $laporans->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $laporans->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
