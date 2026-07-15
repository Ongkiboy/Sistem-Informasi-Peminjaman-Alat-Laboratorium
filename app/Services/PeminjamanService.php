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
	public function tolakPeminjaman(Peminjaman $peminjaman): void
	{
		// Guard: hanya bisa tolak status pending
		if ($peminjaman->status !== 'pending') {
			throw new \Exception('Hanya pengajuan berstatus pending yang bisa ditolak.');
		}

		DB::transaction(function () use ($peminjaman) {
			// Lock baris alat sebelum ubah stok
			$alat = $peminjaman->alat()->lockForUpdate()->first();

			// Kembalikan stok — guard agar tidak melebihi total_stok
			$stokBaru = min(
				$alat->stok_tersedia + $peminjaman->jumlah,
				$alat->total_stok
			);
			$alat->update(['stok_tersedia' => $stokBaru]);

			$peminjaman->update([
				'status'       => 'rejected',
				'ditolak_pada' => now(),
			]);
		});
	}
	public function konfirmasiDiambil(Peminjaman $peminjaman): void
	{
		// Guard: hanya bisa dari status approved
		if ($peminjaman->status !== 'approved') {
			throw new \Exception('Hanya pengajuan berstatus approved yang bisa dikonfirmasi diambil.');
		}

		$peminjaman->update([
			'status'          => 'borrowed',
			'tanggal_diambil' => now(),
		]);
	}
	public function konfirmasiPengembalian(Peminjaman $peminjaman): void
	{
		// Guard: hanya bisa dari status borrowed
		if ($peminjaman->status !== 'borrowed') {
			throw new \Exception('Hanya pengajuan berstatus borrowed yang bisa dikonfirmasi kembali.');
		}

		DB::transaction(function () use ($peminjaman) {
			$alat = $peminjaman->alat()->lockForUpdate()->first();

			// Guard wajib: stok_tersedia tidak boleh melebihi total_stok
			$stokBaru = min(
				$alat->stok_tersedia + $peminjaman->jumlah,
				$alat->total_stok
			);

			$alat->update(['stok_tersedia' => $stokBaru]);

			$peminjaman->update([
				'status'                 => 'returned',
				'tanggal_kembali_aktual' => now(),
			]);
		});
	}
}
