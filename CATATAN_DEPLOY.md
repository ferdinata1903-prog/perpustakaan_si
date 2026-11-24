# Catatan Deploy Modul 7

## Galat 1: Versi runtime vercel-php
- Galat: build gagal / PHP tidak sesuai dependensi
- Penyebab: versi runtime awal tidak cocok dengan PHP proyek
- Solusi: ganti ke vercel-php@0.9.0 (PHP 8.4) di vercel.json

## Galat 2: Dropdown kategori kosong dan daftar buku gagal dimuat
- Galat: "Respon server bukan JSON (200)", /api/kategori menghasilkan 404 HTML
- Penyebab: awalan route /api bentrok dengan folder api/ milik Vercel
- Solusi: ganti prefix API menjadi /data (bootstrap/app.php dan buku.js)

## Error 3: Form login terus mengulang (di Vercel)
- Error: setelah mengisi email dan password lalu klik Login, halaman kembali ke form login tanpa pesan error. Terjadi di Vercel.
- Penyebab: Vercel menjalankan aplikasi di belakang proxy. Tanpa pengaturan trusted proxy, Laravel tidak mengenali bahwa permintaan memakai HTTPS, sehingga cookie sesi tidak terbaca di permintaan berikutnya dan pengguna dianggap belum login. (... tambahkan penyebab lain jika ternyata ada, misalnya env sesi yang belum sesuai)
- Solusi: menambahkan $middleware->trustProxies(at: '*') di bootstrap/app.php (... dan sebutkan perubahan env di Vercel bila ada), lalu melakukan Redeploy karena perubahan env hanya terbaca oleh deployment baru.