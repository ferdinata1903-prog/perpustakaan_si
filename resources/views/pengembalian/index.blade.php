<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengembalian Buku</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        @if (session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <div>
            <h3 class="font-semibold mb-2">Sedang Dipinjam</h3>
            <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-4 py-3">Anggota</th>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Tanggal Pinjam</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dipinjam as $p)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $p->anggota->nama ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_pinjam }}</td>
                                <td class="px-4 py-3">
                                    @can('mencatat pengembalian buku')
                                        <form method="POST" action="{{ route('pengembalian.catat', $p) }}"
                                              onsubmit="return confirm('Catat buku ini sebagai dikembalikan?')">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-1 bg-gray-800 text-white rounded">Catat Pengembalian</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-3">Tidak ada buku yang sedang dipinjam.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <h3 class="font-semibold mb-2">10 Pengembalian Terakhir</h3>
            <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-4 py-3">Anggota</th>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Tanggal Pinjam</th>
                            <th class="px-4 py-3">Tanggal Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($selesai as $p)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $p->anggota->nama ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_pinjam }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_kembali }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-3">Belum ada pengembalian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>