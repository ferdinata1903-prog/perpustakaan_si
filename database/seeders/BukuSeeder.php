<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::first() ?? Kategori::create(['nama' => 'Teknologi Informasi']);

        Buku::firstOrCreate(
            ['judul' => "<script>alert('250441100104')</script>"],
            [
                'kategori_id' => $kategori->id,
                'penulis' => 'Hacker XSS Test',
                'tahun_terbit' => 2024,
            ]
        );

        if (Buku::count() < 5) {
            Buku::factory()->count(5)->create();
        }
    }
}
