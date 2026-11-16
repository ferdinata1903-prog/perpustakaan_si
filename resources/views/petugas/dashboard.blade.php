<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Petugas</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Buku</p>
                <p class="text-3xl font-semibold">{{ $totalBuku }}</p>
            </div>
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Peminjaman</p>
                <p class="text-3xl font-semibold">{{ $totalPeminjaman }}</p>
            </div>
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                <p class="text-3xl font-semibold">{{ $sedangDipinjam }}</p>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            @can('kelola-buku')
                <a href="{{ route('buku.kelola') }}" class="px-4 py-2 bg-gray-800 text-white rounded">Kelola Buku</a>
            @endcan
            @can('kelola peminjaman')
                <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded">Peminjaman</a>
            @endcan
            @can('kelola pengembalian')
                <a href="{{ route('pengembalian.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded">Pengembalian</a>
            @endcan
            @can('lihat laporan perpustakaan')
                <a href="{{ route('laporan.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded">Laporan</a>
            @endcan
        </div>
    </div>
</x-app-layout>