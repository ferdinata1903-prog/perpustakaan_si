<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    // A2: Pencarian rentan SQL Injection
    public function cari(Request $request)
    {
        $judul = $request->query('judul', '');
        $hasil = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");

        return response()->json($hasil);
    }

    // A3: Hapus buku yang dipanggil oleh route GET /buku/{buku}/hapus
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function index()
    {
        $daftarBuku = Buku::with('kategori')->get()->map(function ($buku) {
            return [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'tahun' => $buku->tahun_terbit,
                'kategori' => $buku->kategori?->nama ?? '-',
            ];
        });

        return view('buku.index', ['daftarBuku' => $daftarBuku]);
    }

    public function show($id)
    {
        $data = Buku::with('kategori')->find($id);

        $buku = $data ? [
            'id' => $data->id,
            'judul' => $data->judul,
            'penulis' => $data->penulis,
            'tahun' => $data->tahun_terbit,
            'kategori' => $data->kategori?->nama ?? '-',
        ] : null;

        return view('buku.show', ['buku' => $buku]);
    }

    public function kelola()
    {
        return view('buku.kelola');
    }
}