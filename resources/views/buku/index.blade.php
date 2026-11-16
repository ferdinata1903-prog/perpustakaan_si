@extends('layouts.library')

@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <p class="sub">Data diambil langsung dari API lewat Fetch, tabel diperbarui tanpa reload halaman.</p>

    @can('kelola data buku')
        <p><a href="{{ route('buku.kelola') }}" class="btn btn-sm">Kelola Buku</a></p>
    @endcan

    <table id="tabel-buku" style="width:100%; margin-top:1.5rem; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tabel-body">
            <tr><td colspan="5">Memuat data...</td></tr>
        </tbody>
    </table>
@vite('resources/js/buku.js')
@endsection