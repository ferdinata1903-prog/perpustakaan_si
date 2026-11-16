<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanSayaController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Pintu depan: diarahkan sesuai role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // A2: Pencarian buku rentan SQL Injection
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');

    // A3: Hapus buku via GET (rentan CSRF)
    Route::get('/buku/{buku}/hapus', [BukuController::class, 'destroy'])->name('buku.hapus');

    // A4: Detail peminjaman tanpa pemeriksaan pemilik (IDOR)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    // Daftar dan detail buku: semua role
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->middleware('permission:lihat daftar buku')->name('buku.show');

    // Ajukan peminjaman atas nama sendiri
    Route::post('/buku/{id}/pinjam', [PeminjamanSayaController::class, 'ajukan'])
        ->middleware('permission:mengajukan peminjaman buku')->name('buku.pinjam');

    // Pengelolaan buku: admin dan petugas
    Route::get('/kelola/buku', [BukuController::class, 'kelola'])
        ->middleware('permission:kelola data buku')->name('buku.kelola');

    // Profil milik sendiri
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');
});

// Riwayat peminjaman: permission + pemeriksaan pemilik (Policy)
Route::middleware(['auth', 'permission:melihat riwayat peminjaman sendiri'])->group(function () {
    Route::get('/riwayat-peminjaman', [PeminjamanSayaController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat-peminjaman/{anggota}', [PeminjamanSayaController::class, 'show'])->name('riwayat.show');
});

// Dashboard admin
Route::middleware(['auth', 'permission:akses dashboard admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    });

// Dashboard petugas
Route::middleware(['auth', 'permission:akses dashboard petugas'])
    ->prefix('petugas')->name('petugas.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard');
    });

// Penetapan role: permission "kelola role pengguna"
Route::middleware(['auth', 'permission:kelola role pengguna'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role');
    });

// Kelola akun: permission "kelola data pengguna"
Route::middleware(['auth', 'permission:kelola data pengguna'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

// Peminjaman
Route::middleware(['auth', 'permission:kelola peminjaman'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
});

Route::middleware(['auth', 'permission:memproses persetujuan peminjaman'])->group(function () {
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});

// Pengembalian
Route::middleware(['auth', 'permission:kelola pengembalian'])->group(function () {
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
});

Route::middleware(['auth', 'permission:mencatat pengembalian buku'])->group(function () {
    Route::patch('/pengembalian/{peminjaman}', [PengembalianController::class, 'catat'])->name('pengembalian.catat');
});

// Laporan
Route::middleware(['auth', 'permission:lihat laporan perpustakaan'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

require __DIR__.'/auth.php';