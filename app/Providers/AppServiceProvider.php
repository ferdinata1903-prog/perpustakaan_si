<?php

namespace App\Providers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Policies\PeminjamanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate kelola-buku: hanya izinkan role admin dan petugas
        Gate::define('kelola-buku', function (User $user) {
            return $user->hasRole(['admin', 'petugas']);
        });

        // Daftarkan PeminjamanPolicy
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);
    }
}
