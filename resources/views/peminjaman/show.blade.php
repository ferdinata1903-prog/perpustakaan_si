<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Peminjaman #{{ $peminjaman->id }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">ID Peminjaman</p>
                <p class="text-lg font-bold text-gray-800">#{{ $peminjaman->id }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Nama Peminjam / Anggota</p>
                <p class="text-base text-gray-800">{{ $peminjaman->anggota->nama ?? '-' }} (ID Anggota: {{ $peminjaman->anggota_id }})</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Judul Buku</p>
                <p class="text-base text-gray-800">{{ $peminjaman->buku->judul ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal Pinjam</p>
                <p class="text-base text-gray-800">{{ $peminjaman->tanggal_pinjam }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal Kembali</p>
                <p class="text-base text-gray-800">{{ $peminjaman->tanggal_kembali ?? 'Masih Dipinjam' }}</p>
            </div>
            <div class="pt-4 border-t flex gap-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-800 text-white rounded text-sm">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>
