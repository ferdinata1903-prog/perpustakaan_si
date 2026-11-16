<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User;

class AnggotaPolicy
{
    // Riwayat boleh dilihat oleh pemiliknya sendiri,
    // atau oleh yang berhak mengelola peminjaman (admin/petugas).
    public function viewRiwayat(User $user, Anggota $anggota): bool
    {
        return $user->id === $anggota->user_id
            || $user->can('kelola peminjaman');
    }
}