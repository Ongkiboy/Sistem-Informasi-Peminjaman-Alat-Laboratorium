<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'pengguna_id', 'alat_id', 'jumlah',
        'tanggal_pinjam', 'tanggal_rencana_kembali',
        'tanggal_diambil', 'tanggal_kembali_aktual',
        'status', 'disetujui_pada', 'ditolak_pada',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'          => 'date',
            'tanggal_rencana_kembali' => 'date',
            'tanggal_diambil'         => 'datetime',
            'tanggal_kembali_aktual'  => 'datetime',
            'disetujui_pada'          => 'datetime',
            'ditolak_pada'            => 'datetime',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function masihAktif(): bool
    {
        return in_array($this->status, ['pending', 'approved', 'borrowed']);
    }

    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeAktif($query)   { return $query->whereIn('status', ['approved', 'borrowed']); }
}