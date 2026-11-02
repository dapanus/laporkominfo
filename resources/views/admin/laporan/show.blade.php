<x-layouts.admin :title="'Detail Laporan'" :header="'Detail Laporan'">
    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Header --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $laporan->jenis_laporan === 'pengaduan' ? 'bg-amber-100 text-amber-700' : 'bg-secondary-100 text-secondary-700' }}">{{ ucfirst($laporan->jenis_laporan) }}</span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $laporan->status === 'menunggu_verifikasi' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $laporan->status === 'diverifikasi' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $laporan->status === 'diproses' ? 'bg-violet-100 text-violet-700' : '' }}
                        {{ $laporan->status === 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $laporan->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                    ">{{ str_replace('_', ' ', ucfirst($laporan->status)) }}</span>
                    <span class="text-xs text-gray-400 font-mono">{{ $laporan->id_laporan }}</span>
                </div>
                <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $laporan->judul }}</h1>
                <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                    <span>Pelapor: <strong>{{ $laporan->user->name ?? 'Guest' }}</strong></span>
                    <span>{{ $laporan->created_at->format('d M Y, H:i') }}</span>
                    <span>{{ str_replace('_', ' ', ucfirst($laporan->kategori)) }}</span>
                    @if($laporan->kecamatan)<span>📍 {{ $laporan->desa }}, {{ $laporan->kecamatan }}</span>@endif
                    @if($laporan->detail_alamat)<span class="text-gray-400">{{ $laporan->detail_alamat }}</span>@endif
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
                        <div class="aspect-square rounded-xl overflow-hidden border border-gray-200">
                            <img src="{{ Storage::url($foto) }}" alt="Bukti" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar: Actions --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Moderasi Panel --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-2 mb-5 pb-3 border-b border-gray-50">
                    <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-bold text-gray-900 font-sans">Aksi Moderasi</h2>
                </div>

                <form method="POST" action="{{ route('admin.laporan.update', $laporan) }}" class="space-y-4" id="moderation-form">
                    @csrf
                    @method('PATCH')

                    {{-- Custom Select Dropdown with Alpine.js --}}
                    <div x-data="{ 
                        open: false, 
                        selectedStatus: '{{ $laporan->status }}',
                        statuses: [
                            { value: 'menunggu_verifikasi', label: 'Menunggu Verifikasi', colorBg: 'bg-amber-500' },
                            { value: 'diverifikasi', label: 'Diverifikasi', colorBg: 'bg-blue-500' },
                            { value: 'diproses', label: 'Diproses', colorBg: 'bg-violet-500' },
                            { value: 'selesai', label: 'Selesai', colorBg: 'bg-green-500' },
                            { value: 'ditolak', label: 'Ditolak', colorBg: 'bg-red-500' }
                        ],
                        get current() {
                            return this.statuses.find(s => s.value === this.selectedStatus) || this.statuses[0];
                        }
                    }" class="relative">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Ubah Status</label>
                        <input type="hidden" name="status" :value="selectedStatus">
                        
                        <button type="button" @click="open = !open" @click.away="open = false" 
                            class="w-full flex items-center justify-between px-3.5 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm font-medium focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white outline-none text-left transition-all duration-200">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full shrink-0 animate-pulse" :class="current.colorBg"></span>
                                <span class="text-gray-800" x-text="current.label"></span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="opacity-0 scale-95" 
                             x-transition:enter-end="opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="opacity-100 scale-100" 
                             x-transition:leave-end="opacity-0 scale-95" 
                             class="absolute z-50 w-full mt-1.5 bg-white border border-gray-100 rounded-xl shadow-xl py-1 max-h-60 overflow-y-auto" style="display: none;">
                            <template x-for="status in statuses" :key="status.value">
                                <button type="button" @click="selectedStatus = status.value; open = false" 
                                    class="w-full flex items-center gap-3 px-3.5 py-2.5 text-sm hover:bg-gray-50 transition-colors text-left"
                                    :class="selectedStatus === status.value ? 'bg-primary-50/50 text-primary-700 font-semibold' : 'text-gray-700'">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0" :class="status.colorBg"></span>
                                    <span class="flex-1" x-text="status.label"></span>
                                    <svg x-show="selectedStatus === status.value" class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Catatan Admin</label>
                        <textarea name="catatan_admin" rows="4" class="w-full px-3.5 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white outline-none resize-none transition-all duration-200" placeholder="Tambahkan catatan atau alasan...">{{ $laporan->catatan_admin }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 gradient-hero text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-2 mb-5 pb-3 border-b border-gray-50">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-bold text-gray-900 font-sans">Aksi Cepat</h2>
                </div>

                <div class="space-y-2">
                    @if($laporan->status === 'menunggu_verifikasi')
                        <div class="grid grid-cols-2 gap-2.5">
                            <form method="POST" action="{{ route('admin.laporan.update', $laporan) }}" class="w-full">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="diverifikasi">
                                <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Verifikasi
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.laporan.update', $laporan) }}" class="w-full">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="w-full py-2.5 px-4 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-bold rounded-xl hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                    @if($laporan->status === 'diverifikasi')
                        <form method="POST" action="{{ route('admin.laporan.update', $laporan) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="diproses">
                            <button type="submit" class="w-full py-3 px-4 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Proses Laporan
                            </button>
                        </form>
                    @endif
                    @if($laporan->status === 'diproses')
                        <form method="POST" action="{{ route('admin.laporan.update', $laporan) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Back --}}
            <a href="{{ route('admin.laporan.index') }}" class="flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-primary-600 transition-colors">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>
</x-layouts.admin>
