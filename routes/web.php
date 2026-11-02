<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminLaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    $laporans = \App\Models\Laporan::where('status', '!=', 'ditolak')
        ->latest()
        ->take(3)
        ->get();

    $displayLaporans = collect();
    foreach ($laporans as $laporan) {
        $displayLaporans->push([
            'is_dummy' => false,
            'id_laporan' => $laporan->id_laporan,
            'jenis_laporan' => $laporan->jenis_laporan,
            'kategori' => $laporan->kategori,
            'judul' => $laporan->judul,
            'deskripsi' => $laporan->deskripsi,
            'status' => $laporan->status,
            'time' => $laporan->created_at->diffForHumans(),
        ]);
    }

    $fallbacks = [
        [
            'is_dummy' => true,
            'jenis_laporan' => 'pengaduan',
            'kategori' => 'infrastruktur_jaringan',
            'judul' => 'Pengaduan Baru',
            'deskripsi' => 'WiFi publik di kecamatan Kodi tidak berfungsi sejak 3 hari lalu...',
            'status' => 'menunggu_verifikasi',
            'time' => '2 menit lalu',
        ],
        [
            'is_dummy' => true,
            'jenis_laporan' => 'selesai',
            'kategori' => 'layanan_digital',
            'judul' => 'Selesai',
            'deskripsi' => 'Website pemkab sudah diperbaiki dan berjalan normal.',
            'status' => 'selesai',
            'time' => null,
        ],
        [
            'is_dummy' => true,
            'jenis_laporan' => 'aspirasi',
            'kategori' => 'data_sistem',
            'judul' => 'Aspirasi',
            'deskripsi' => 'Usul digitalisasi data kependudukan desa...',
            'status' => null,
            'time' => null,
        ]
    ];

    for ($i = $displayLaporans->count(); $i < 3; $i++) {
        $displayLaporans->push($fallbacks[$i]);
    }

    return view('landing', ['laporans' => $displayLaporans]);
})->name('home');

// Laporan — public access
Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/laporan/cari', [LaporanController::class, 'search'])->name('laporan.search');
Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // User reports list
    Route::get('/laporan-saya', [LaporanController::class, 'index'])->name('laporan.index');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{laporan}', [AdminLaporanController::class, 'show'])->name('laporan.show');
    Route::patch('/laporan/{laporan}', [AdminLaporanController::class, 'update'])->name('laporan.update');
});

require __DIR__.'/auth.php';
