<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    public function index()
    {
        $dipinjam = Peminjaman::with(['anggota', 'buku'])
            ->whereNull('tanggal_kembali')
            ->latest('tanggal_pinjam')
            ->get();

        $selesai = Peminjaman::with(['anggota', 'buku'])
            ->whereNotNull('tanggal_kembali')
            ->latest('tanggal_kembali')
            ->limit(10)
            ->get();

        return view('pengembalian.index', compact('dipinjam', 'selesai'));
    }

    public function catat(Peminjaman $peminjaman)
    {
        if ($peminjaman->tanggal_kembali) {
            return back()->with('error', 'Peminjaman ini sudah tercatat dikembalikan.');
        }

        $peminjaman->update(['tanggal_kembali' => now()->toDateString()]);

        return back()->with('success', 'Pengembalian berhasil dicatat.');
    }
}