<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    public function index()
    {
        $daftar = Peminjaman::with(['anggota', 'buku'])
            ->latest('tanggal_pinjam')
            ->get();

        return view('peminjaman.index', compact('daftar'));
    }

    public function create()
    {
        return view('peminjaman.create', [
            'anggotas' => Anggota::orderBy('nama')->get(),
            'bukus'    => Buku::orderBy('judul')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'anggota_id'     => ['required', 'exists:anggotas,id'],
            'buku_id'        => ['required', 'exists:bukus,id'],
            'tanggal_pinjam' => ['required', 'date'],
        ]);

        Peminjaman::create($data);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat.');
    }

    // Detail peminjaman dilindungi PeminjamanPolicy
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);

        Gate::authorize('view', $peminjaman);

        return view('peminjaman.show', compact('peminjaman'));
    }
}