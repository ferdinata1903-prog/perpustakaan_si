<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PeminjamanSayaController extends Controller
{
    // Riwayat milik akun yang sedang login
    public function index(Request $request)
    {
        $anggota = $request->user()->pastikanAnggota();

        return view('riwayat.index', [
            'anggota' => $anggota,
            'daftar'  => $anggota->peminjamans()->with('buku')->latest('tanggal_pinjam')->get(),
        ]);
    }

    // Riwayat anggota tertentu: dijaga Policy (identitas pemilik)
    public function show(Anggota $anggota)
    {
        Gate::authorize('viewRiwayat', $anggota);

        return view('riwayat.index', [
            'anggota' => $anggota,
            'daftar'  => $anggota->peminjamans()->with('buku')->latest('tanggal_pinjam')->get(),
        ]);
    }

    // Mengajukan peminjaman atas nama akun sendiri
    public function ajukan(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $anggota = $request->user()->pastikanAnggota();

        $masihDipinjam = $anggota->peminjamans()
            ->where('buku_id', $buku->id)
            ->whereNull('tanggal_kembali')
            ->exists();

        if ($masihDipinjam) {
            return back()->with('error', 'Anda masih meminjam buku ini.');
        }

        $anggota->peminjamans()->create([
            'buku_id'        => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
        ]);

        return redirect()->route('riwayat.index')
            ->with('success', "Peminjaman \"{$buku->judul}\" berhasil diajukan.");
    }
}