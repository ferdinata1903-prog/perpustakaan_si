<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna dan Role</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        @can('kelola data pengguna')
            <a href="{{ route('admin.users.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-gray-800 text-white rounded">+ Tambah Pengguna</a>
        @endcan

        <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role saat ini</th>
                        <th class="px-4 py-3">Ubah role</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="border-gray-300 rounded text-sm">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="px-3 py-1 bg-gray-800 text-white rounded">Simpan</button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                @can('kelola data pengguna')
                                    <div class="flex gap-3 items-center">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Edit</a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('Hapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600">Hapus</button>
                                        </form>
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>