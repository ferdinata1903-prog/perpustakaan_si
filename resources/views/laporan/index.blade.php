<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Perpustakaan</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Buku</p>
                <p class="text-3xl font-semibold">{{ $totalBuku }}</p>
            </div>
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Anggota</p>
                <p class="text-3xl font-semibold">{{ $totalAnggota }}</p>
            </div>
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Peminjaman</p>
                <p class="text-3xl font-semibold">{{ $totalPeminjaman }}</p>
            </div>
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                <p class="text-3xl font-semibold">{{ $sedangDipinjam }}</p>
            </div>
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Sudah Kembali</p>
                <p class="text-3xl font-semibold">{{ $sudahKembali }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white shadow sm:rounded-lg p-5">
                <h3 class="font-semibold mb-3">5 Buku Paling Sering Dipinjam</h3>
                <table class="min-w-full text-sm">
                    <thead class="text-left bg-gray-50">
                        <tr><th class="px-3 py-2">Judul</th><th class="px-3 py-2">Dipinjam</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($bukuPopuler as $b)
                            <tr class="border-t">
                                <td class="px-3 py-2">{{ $b->judul }}</td>
                                <td class="px-3 py-2">{{ $b->peminjamans_count }}x</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-3 py-2">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-5">
                <h3 class="font-semibold mb-3">Jumlah Buku per Kategori</h3>
                <table class="min-w-full text-sm">
                    <thead class="text-left bg-gray-50">
                        <tr><th class="px-3 py-2">Kategori</th><th class="px-3 py-2">Jumlah Buku</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($perKategori as $k)
                            <tr class="border-t">
                                <td class="px-3 py-2">{{ $k->nama }}</td>
                                <td class="px-3 py-2">{{ $k->bukus_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-3 py-2">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>