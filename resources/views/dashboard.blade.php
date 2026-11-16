<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <p>Selamat datang, {{ Auth::user()->name }}.</p>
            @can('lihat daftar buku')
                <a href="{{ route('buku.index') }}" class="inline-block mt-4 px-4 py-2 bg-gray-800 text-white rounded">Lihat Daftar Buku</a>
            @endcan
        </div>
    </div>
</x-app-layout>