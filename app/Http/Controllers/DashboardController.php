<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Pintu depan: arahkan sesuai permission dashboard
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->can('akses dashboard admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->can('akses dashboard petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        return view('dashboard'); // siswa
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'totalBuku'      => Buku::count(),
            'totalPengguna'  => User::count(),
            'totalPeminjaman'=> Peminjaman::count(),
            'sedangDipinjam' => Peminjaman::whereNull('tanggal_kembali')->count(),
        ]);
    }

    public function petugas()
    {
        return view('petugas.dashboard', [
            'totalBuku'      => Buku::count(),
            'totalPeminjaman'=> Peminjaman::count(),
            'sedangDipinjam' => Peminjaman::whereNull('tanggal_kembali')->count(),
        ]);
    }
}