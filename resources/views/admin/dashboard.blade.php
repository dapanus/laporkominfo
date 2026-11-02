<x-layouts.admin :title="'Dashboard'" :header="'Dashboard'">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Total Laporan', 'value' => $totalLaporan ?? 0, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>', 'color' => 'primary', 'bg' => 'bg-primary-50', 'text' => 'text-primary-600'],
                ['label' => 'Pengaduan', 'value' => $totalPengaduan ?? 0, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>', 'color' => 'amber', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
                ['label' => 'Aspirasi', 'value' => $totalAspirasi ?? 0, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>', 'color' => 'secondary', 'bg' => 'bg-secondary-50', 'text' => 'text-secondary-600'],
                ['label' => 'Menunggu', 'value' => $totalMenunggu ?? 0, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'color' => 'yellow', 'bg' => 'bg-yellow-50', 'text' => 'text-yellow-600'],
                ['label' => 'Selesai', 'value' => $totalSelesai ?? 0, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'color' => 'green', 'bg' => 'bg-green-50', 'text' => 'text-green-600'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover-lift transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl {{ $stat['bg'] }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 {{ $stat['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $stat['icon'] !!}</svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                        <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Charts Row --}}
    <div class="grid lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Distribusi Status</h3>
            <canvas id="statusChart" height="200"></canvas>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Laporan per Kategori</h3>
            <canvas id="categoryChart" height="200"></canvas>
        </div>
    </div>

    {{-- Recent Reports --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Laporan Terbaru</h3>
            <a href="{{ route('admin.laporan.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="recent-reports-table">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Judul</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jenis</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentLaporans ?? [] as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-xs font-mono text-gray-500">{{ $item->id_laporan }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 max-w-[200px] truncate">{{ $item->judul }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $item->jenis_laporan === 'pengaduan' ? 'bg-amber-100 text-amber-700' : 'bg-secondary-100 text-secondary-700' }}">{{ ucfirst($item->jenis_laporan) }}</span>
                            </td>
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
                        <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart.js --}}
    @php
        $chartStatus = $statusData ?? ['Menunggu' => 0, 'Diverifikasi' => 0, 'Diproses' => 0, 'Selesai' => 0, 'Ditolak' => 0];
        $chartCategory = $categoryData ?? ['Infrastruktur' => 0, 'Layanan Digital' => 0, 'Hoaks' => 0, 'Data & Sistem' => 0];
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusData = @json($chartStatus);
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData),
                    datasets: [{ data: Object.values(statusData), backgroundColor: ['#FBBF24','#3B82F6','#8B5CF6','#22C55E','#EF4444'], borderWidth: 0, borderRadius: 4 }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyleWidth: 8 } } }, cutout: '65%' }
            });

            const catData = @json($chartCategory);
            new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(catData),
                    datasets: [{ data: Object.values(catData), backgroundColor: ['#3B82F6','#8B5CF6','#EF4444','#10B981'], borderRadius: 8, borderSkipped: false }]
                },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } } }
            });
        });
    </script>
</x-layouts.admin>
