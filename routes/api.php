<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\RekapController;
use Illuminate\Support\Facades\Route;

// Baca buku dan kategori: permission "lihat daftar buku"
Route::middleware(['web', 'auth', 'permission:lihat daftar buku'])->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/buku', [BukuController::class, 'index'])->name('api.buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])->name('api.buku.show');
});

// Tambah, ubah, hapus buku: Gate kelola-buku
Route::middleware(['web', 'auth', 'can:kelola-buku'])->group(function () {
    Route::post('/buku', [BukuController::class, 'store'])->name('api.buku.store');
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('api.buku.update');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('api.buku.destroy');
});

// Rekap (data laporan): permission "lihat laporan perpustakaan"
Route::middleware(['web', 'auth', 'permission:lihat laporan perpustakaan'])->group(function () {
    Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
    Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
});