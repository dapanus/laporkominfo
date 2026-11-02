<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLaporan = Laporan::count();
        $totalPengaduan = Laporan::where('jenis_laporan', 'pengaduan')->count();
        $totalAspirasi = Laporan::where('jenis_laporan', 'aspirasi')->count();
        $totalMenunggu = Laporan::where('status', 'menunggu_verifikasi')->count();
        $totalSelesai = Laporan::where('status', 'selesai')->count();

        $statusData = [
            'Menunggu' => Laporan::where('status', 'menunggu_verifikasi')->count(),
            'Diverifikasi' => Laporan::where('status', 'diverifikasi')->count(),
            'Diproses' => Laporan::where('status', 'diproses')->count(),
            'Selesai' => Laporan::where('status', 'selesai')->count(),
            'Ditolak' => Laporan::where('status', 'ditolak')->count(),
        ];

        $categoryData = [
            'Infrastruktur' => Laporan::where('kategori', 'infrastruktur_jaringan')->count(),
            'Layanan Digital' => Laporan::where('kategori', 'layanan_digital')->count(),
            'Hoaks' => Laporan::where('kategori', 'hoaks')->count(),
            'Data & Sistem' => Laporan::where('kategori', 'data_sistem')->count(),
        ];

        $recentLaporans = Laporan::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalLaporan', 'totalPengaduan', 'totalAspirasi',
            'totalMenunggu', 'totalSelesai',
            'statusData', 'categoryData', 'recentLaporans'
        ));
    }
}
