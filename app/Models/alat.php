<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\AlatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
     use SoftDeletes;

    protected $table = 'alat';

    protected $fillable = [
        'nama_alat', 'kode_barang', 'deskripsi',
        'kondisi', 'total_stok', 'stok_tersedia', 'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'total_stok'    => 'integer',
            'stok_tersedia' => 'integer',
        ];
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'alat_id');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }

    public function memilikiPeminjamanAktif(): bool
    {
        return $this->peminjaman()
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->exists();
    }

    public function scopeTersedia($query)
    {
        return $query->where('stok_tersedia', '>', 0);
    }    
}
