<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Spatie menyimpan permission di cache, jadi cache dikosongkan dulu
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Pengelompokan 16 permission sesuai tabel di soal
        $khususAdmin = [
            'akses dashboard admin',
            'kelola data pengguna',
            'kelola role pengguna',
        ];

        $khususPetugas = [
            'akses dashboard petugas',
        ];

        $adminDanPetugas = [
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'lihat laporan perpustakaan',
        ];

        $semuaRole = [
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        // 1. Buat semua permission (3 + 1 + 6 + 6 = 16)
        $semuaPermission = array_merge($khususAdmin, $khususPetugas, $adminDanPetugas, $semuaRole);

        foreach ($semuaPermission as $nama) {
            Permission::firstOrCreate(['name' => $nama, 'guard_name' => 'web']);
        }

        // 2. Buat 3 role
        $admin   = Role::firstOrCreate(['name' => 'admin',   'guard_name' => 'web']);
        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $siswa   = Role::firstOrCreate(['name' => 'siswa',   'guard_name' => 'web']);

        // 3. Tetapkan permission ke tiap role
        $admin->syncPermissions(array_merge($khususAdmin, $adminDanPetugas, $semuaRole));
        $petugas->syncPermissions(array_merge($khususPetugas, $adminDanPetugas, $semuaRole));
        $siswa->syncPermissions($semuaRole);
    }
}   