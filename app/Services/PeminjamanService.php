<?php

namespace App\Services;

class PeminjamanService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }
    	public function ajukanPeminjaman(array $data, int $penggunaId): Peminjaman
	{
	    return DB::transaction(function () use ($data, $penggunaId) {
	        $alat = Alat::lockForUpdate()->findOrFail($data['alat_id']);
	
	        if ($alat->stok_tersedia < $data['jumlah']) {
	            throw new StokTidakCukupException(
	                "Stok tidak mencukupi. Tersedia:{$alat->stok_tersedia} unit."
	            );
	        }
	
	        $sudahAda = Peminjaman::where('pengguna_id', $penggunaId)
	            ->where('alat_id', $data['alat_id'])
	            ->whereIn('status', ['pending', 'approved'])
	            ->exists();
	
	        if ($sudahAda) {
	            throw new \Exception('Kamu masih memiliki pengajuan aktif untuk alat ini.');
	        }
	
	        $alat->decrement('stok_tersedia', $data['jumlah']);
	
	        return Peminjaman::create([
	            'pengguna_id'             => $penggunaId,
	            'alat_id'                 => $data['alat_id'],
	            'jumlah'                  => $data['jumlah'],
	            'tanggal_pinjam'          => $data['tanggal_pinjam'],
	            'tanggal_rencana_kembali' => $data['tanggal_rencana_kembali'],
	            'status'                  => 'pending',
	        ]);
	    });
	}
}
