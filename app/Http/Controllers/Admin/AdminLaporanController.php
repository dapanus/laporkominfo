<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with('user')->latest();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('id_laporan', 'like', '%' . $request->q . '%')
                  ->orWhere('judul', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_laporan', $request->jenis);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $laporans = $query->paginate(15)->withQueryString();

        return view('admin.laporan.index', compact('laporans'));
    }

    public function show(Laporan $laporan)
    {
        $laporan->load('user');
        return view('admin.laporan.show', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu_verifikasi,diverifikasi,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->route('admin.laporan.show', $laporan)
            ->with('success', 'Status laporan berhasil diperbarui.');
    }
}
