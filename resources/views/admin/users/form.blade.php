<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->exists ? 'Edit Pengguna' : 'Tambah Pengguna' }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="POST"
                  action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
                  class="space-y-4">
                @csrf
                @if ($user->exists)
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 w-full border-gray-300 rounded" required>
                    @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="mt-1 w-full border-gray-300 rounded" required>
                    @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                @unless ($user->exists)
                    <div>
                        <label class="block text-sm font-medium">Role</label>
                        <select name="role" class="mt-1 w-full border-gray-300 rounded" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role') === $role->name)>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                @endunless

                <div>
                    <label class="block text-sm font-medium">
                        Password {{ $user->exists ? '(kosongkan jika tidak diganti)' : '' }}
                    </label>
                    <input type="password" name="password" class="mt-1 w-full border-gray-300 rounded"
                           {{ $user->exists ? '' : 'required' }}>
                    @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="mt-1 w-full border-gray-300 rounded">
                </div>

                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Simpan</button>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>