<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catat Peminjaman</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Anggota</label>
                    <select name="anggota_id" class="mt-1 w-full border-gray-300 rounded" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach ($anggotas as $a)
                            <option value="{{ $a->id }}" @selected(old('anggota_id') == $a->id)>{{ $a->nama }}</option>
                        @endforeach
                    </select>
                    @error('anggota_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Buku</label>
                    <select name="buku_id" class="mt-1 w-full border-gray-300 rounded" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($bukus as $b)
                            <option value="{{ $b->id }}" @selected(old('buku_id') == $b->id)>{{ $b->judul }}</option>
                        @endforeach
                    </select>
                    @error('buku_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', now()->toDateString()) }}"
                           class="mt-1 w-full border-gray-300 rounded" required>
                    @error('tanggal_pinjam') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Simpan</button>
                    <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>