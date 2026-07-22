<?php

namespace App\Services;

use App\Exceptions\StokTidakCukupException;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

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
	public function setujuiPeminjaman(Peminjaman $peminjaman): void
	{
		// Guard: hanya bisa setujui status pending
		if ($peminjaman->status !== 'pending') {
			throw new \Exception('Hanya pengajuan berstatus pending yang bisa disetujui.');
		}

		// Tidak ada perubahan stok — stok sudah dikurangi sejak pengajuan dibuat.
		$peminjaman->update([
			'status'         => 'approved',
			'disetujui_pada' => now(),
		]);
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

			// Kembalikan stok — guard agar tidak melebihi stok_baik (cuma unit baik yang boleh dipinjamkan)
			$stokBaru = min(
				$alat->stok_tersedia + $peminjaman->jumlah,
				$alat->stok_baik
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
	public function konfirmasiPengembalian(Peminjaman $peminjaman, string $kondisiKembali = 'baik'): void
	{
		// Guard: hanya bisa dari status borrowed
		if ($peminjaman->status !== 'borrowed') {
			throw new \Exception('Hanya pengajuan berstatus borrowed yang bisa dikonfirmasi kembali.');
		}

		DB::transaction(function () use ($peminjaman, $kondisiKembali) {
			$alat = $peminjaman->alat()->lockForUpdate()->first();

			if ($kondisiKembali === 'baik') {
				// Balik ke pool baik — guard wajib: stok_tersedia tidak boleh melebihi stok_baik
				$stokBaru = min(
					$alat->stok_tersedia + $peminjaman->jumlah,
					$alat->stok_baik
				);
				$alat->update(['stok_tersedia' => $stokBaru]);
			} else {
				// Balik dalam kondisi rusak — pindahkan unit dari pool baik ke pool rusak yang dipilih.
				// stok_tersedia TIDAK ditambah karena unit rusak tidak tersedia dipinjam lagi.
				$kolomRusak = $kondisiKembali === 'rusak_ringan' ? 'stok_rusak_ringan' : 'stok_rusak_berat';
				$alat->update([
					'stok_baik' => max(0, $alat->stok_baik - $peminjaman->jumlah),
					$kolomRusak => $alat->{$kolomRusak} + $peminjaman->jumlah,
				]);
			}

			$peminjaman->update([
				'status'                 => 'returned',
				'tanggal_kembali_aktual' => now(),
			]);
		});
	}
}
