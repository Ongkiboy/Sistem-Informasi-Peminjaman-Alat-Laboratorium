<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\AlatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Alat extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'alats';

    protected $fillable = [
        'nama_alat', 'kode_barang', 'deskripsi',
        'stok_baik', 'stok_rusak_ringan', 'stok_rusak_berat', 'stok_tersedia',
        'dibuat_oleh', 'gambar',
    ];

    protected function casts(): array
    {
        return [
            'stok_baik'         => 'integer',
            'stok_rusak_ringan' => 'integer',
            'stok_rusak_berat'  => 'integer',
            'stok_tersedia'     => 'integer',
        ];
    }

    public function getTotalStokAttribute(): int
    {
        return $this->stok_baik + $this->stok_rusak_ringan + $this->stok_rusak_berat;
    }

    public function getGambarUrlAttribute(): ?string{
        return $this->gambar ? Storage::disk('public')->url($this->gambar) : null;

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
