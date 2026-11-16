<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'totalBuku'      => Buku::count(),
            'totalAnggota'   => Anggota::count(),
            'totalPeminjaman'=> Peminjaman::count(),
            'sedangDipinjam' => Peminjaman::whereNull('tanggal_kembali')->count(),
            'sudahKembali'   => Peminjaman::whereNotNull('tanggal_kembali')->count(),
            'bukuPopuler'    => Buku::withCount('peminjamans')
                                    ->orderByDesc('peminjamans_count')
                                    ->limit(5)->get(),
            'perKategori'    => Kategori::withCount('bukus')->orderBy('nama')->get(),
        ]);
    }
}