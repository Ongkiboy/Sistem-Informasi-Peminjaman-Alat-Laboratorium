<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Factories\PenggunaFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nim',  
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'pengguna_id');
    }

    // Helper
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
}