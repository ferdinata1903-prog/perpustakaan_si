<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * Tentukan apakah user boleh melihat data peminjaman.
     * Admin dan petugas boleh melihat semua peminjaman.
     * Siswa hanya boleh melihat peminjaman miliknya sendiri.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if ($user->hasRole(['admin', 'petugas'])) {
            return true;
        }

        return $peminjaman->anggota && $peminjaman->anggota->user_id === $user->id;
    }
}
