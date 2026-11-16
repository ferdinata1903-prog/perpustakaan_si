<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($anggota->user_id === auth()->id())
                Riwayat Peminjaman Saya
            @else
                Riwayat Peminjaman: {{ $anggota->nama }}
            @endif
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Buku</th>
                        <th class="px-4 py-3">Tanggal Pinjam</th>
                        <th class="px-4 py-3">Tanggal Kembali</th>
                        @can('melihat status peminjaman sendiri')
                            <th class="px-4 py-3">Status</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $p)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $p->buku->judul ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->tanggal_pinjam }}</td>
                            <td class="px-4 py-3">{{ $p->tanggal_kembali ?? '-' }}</td>
                            @can('melihat status peminjaman sendiri')
                                <td class="px-4 py-3">
                                    @if ($p->tanggal_kembali)
                                        <span class="px-2 py-1 rounded bg-green-100 text-green-800">Dikembalikan</span>
                                    @else
                                        <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">Dipinjam</span>
                                    @endif
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-3">Belum ada riwayat peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>