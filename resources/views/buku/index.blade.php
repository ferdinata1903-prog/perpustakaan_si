@extends('layouts.library')

@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <p class="sub">Koleksi buku perpustakaan digital.</p>

    @if (session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @can('kelola data buku')
        <p><a href="{{ route('buku.kelola') }}" class="btn btn-sm">Kelola Buku</a></p>
    @endcan

    <table id="tabel-buku" style="width:100%; margin-top:1.5rem; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f3f4f6; text-align: left;">
                <th style="padding: 8px;">Kategori</th>
                <th style="padding: 8px;">Judul</th>
                <th style="padding: 8px;">Penulis</th>
                <th style="padding: 8px;">Tahun Terbit</th>
                <th style="padding: 8px;">Aksi</th>
            </tr>
        </thead>
        <tbody id="tabel-body">
            @forelse ($daftarBuku as $buku)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 8px;">{{ $buku['kategori'] }}</td>
                    <td style="padding: 8px;">{!! $buku['judul'] !!}</td>
                    <td style="padding: 8px;">{{ $buku['penulis'] }}</td>
                    <td style="padding: 8px;">{{ $buku['tahun'] }}</td>
                    <td style="padding: 8px;">
                        <a href="{{ route('buku.show', $buku['id']) }}" class="btn btn-outline btn-sm">Detail</a>
                        @can('kelola data buku')
                            <a href="{{ route('buku.hapus', $buku['id']) }}" class="btn-hapus" style="color: #dc2626; margin-left: 8px; font-size: 0.875rem;">Hapus (GET)</a>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="padding: 8px; text-align: center;">Belum ada data buku.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
