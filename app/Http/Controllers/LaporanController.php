<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Daftar laporan milik user yang login
     */
    public function index(Request $request)
    {
        $query = Laporan::where('user_id', Auth::id())->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporans = $query->paginate(10)->withQueryString();

        return view('laporan.index', compact('laporans'));
    }

    /**
     * Form buat laporan (multi-step wizard)
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Simpan laporan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_laporan' => 'required|in:pengaduan,aspirasi',
            'kategori' => 'required|in:infrastruktur_jaringan,layanan_digital,hoaks,data_sistem',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'detail_alamat' => 'nullable|string|max:500',
            'foto' => 'nullable|array|max:3',
            'foto.*' => 'image|max:2048',
        ]);

        // Handle photo uploads
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('laporan-foto', 'public');
            }
        }

        $laporan = Laporan::create([
            'user_id' => Auth::id(),
            'jenis_laporan' => $validated['jenis_laporan'],
            'kategori' => $validated['kategori'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kecamatan' => $validated['kecamatan'],
            'desa' => $validated['desa'],
            'detail_alamat' => $validated['detail_alamat'] ?? null,
            'foto' => !empty($fotoPaths) ? $fotoPaths : null,
            'status' => 'menunggu_verifikasi',
        ]);

        return redirect()->route('laporan.show', $laporan)
            ->with('success', 'Laporan berhasil dikirim! ID Laporan Anda: ' . $laporan->id_laporan);
    }

    /**
     * Detail laporan
     */
    public function show(Laporan $laporan)
    {
        return view('laporan.show', compact('laporan'));
    }

    /**
     * Cari laporan
     */
    public function search(Request $request)
    {
        $laporan = collect();

        if ($request->filled('q')) {
            $laporan = Laporan::where('id_laporan', 'like', '%' . $request->q . '%')
                ->orWhere('judul', 'like', '%' . $request->q . '%')
                ->latest()
                ->limit(20)
                ->get();
        }

        return view('laporan.search', compact('laporan'));
    }
}
