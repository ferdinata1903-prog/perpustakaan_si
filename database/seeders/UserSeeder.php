<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['name' => 'Admin Perpustakaan',   'email' => 'admin@library.test',   'role' => 'admin'],
            ['name' => 'Petugas Perpustakaan', 'email' => 'petugas@library.test', 'role' => 'petugas'],
            ['name' => 'Siswa Satu',           'email' => 'siswa1@library.test',  'role' => 'siswa'],
            ['name' => 'Siswa Dua',            'email' => 'siswa2@library.test',  'role' => 'siswa'],
        ];

        foreach ($akun as $data) {
            // Penguatan keamanan: ganti password default admin bawaan seeder
            $password = $data['role'] === 'admin'
                ? Hash::make('AdminBaru104!')
                : Hash::make('password123');

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => $password]
            );

            $user->syncRoles($data['role']);

            // Siswa: hubungkan ke data anggota dan beri 2 riwayat contoh
            if ($data['role'] === 'siswa') {
                $anggota = $user->pastikanAnggota();

                if ($anggota->peminjamans()->count() === 0) {
                    foreach (Buku::inRandomOrder()->take(2)->get() as $i => $buku) {
                        $anggota->peminjamans()->create([
                            'buku_id'         => $buku->id,
                            'tanggal_pinjam'  => now()->subDays(rand(3, 20))->toDateString(),
                            'tanggal_kembali' => $i === 0 ? now()->subDay()->toDateString() : null,
                        ]);
                    }
                }
            }
        }
    }
}