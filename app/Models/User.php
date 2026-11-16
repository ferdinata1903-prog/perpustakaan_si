<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function anggota(): HasOne
    {
        return $this->hasOne(Anggota::class);
    }

    // Ambil data anggota milik akun ini; kalau belum ada, dibuatkan otomatis
    public function pastikanAnggota(): Anggota
    {
        $anggota = $this->anggota;

        if (!$anggota) {
            $anggota = $this->anggota()->create([
                'nama'       => $this->name,
                'email'      => $this->email,
                'no_telepon' => '-',
            ]);
            $this->setRelation('anggota', $anggota);
        }

        return $anggota;
    }
}