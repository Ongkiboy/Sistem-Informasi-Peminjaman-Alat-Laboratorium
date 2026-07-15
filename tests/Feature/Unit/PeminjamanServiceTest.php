<?php

use App\Models\Alat;
use App\Models\Pengguna;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;

beforeEach(function () {
    $this->service = new PeminjamanService();
});

it('berhasil membuat peminjaman dan mengurangi stok', function () {
    $mahasiswa = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $Alat = Alat::factory()->create(['total_stok' => 5, 'stok_tersedia' => 5]);

    $peminjaman = $this->service->ajukanPeminjaman([
        'Alat_id'                 => $Alat->id,
        'jumlah'                  => 2,
        'tanggal_pinjam'          => now()->addDay()->toDateString(),
        'tanggal_rencana_kembali' => now()->addDays(3)->toDateString(),
    ], $mahasiswa->id);

    // Cek record peminjaman terbuat
    expect($peminjaman)->toBeInstanceOf(Peminjaman::class);
    expect($peminjaman->status)->toBe('pending');
    expect($peminjaman->jumlah)->toBe(2);

    // Cek stok berkurang
    expect($Alat->fresh()->stok_tersedia)->toBe(3);
});
it('mencegah stok minus saat dua request bersamaan', function () {
    $mahasiswa1 = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $mahasiswa2 = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $Alat = Alat::factory()->create(['total_stok' => 1, 'stok_tersedia' => 1]);

    $service = new PeminjamanService();

    $berhasil = 0;
    $gagal    = 0;

    // Simulasi dua request yang mencoba pinjam Alat yang sama (stok = 1)
    $requests = [
        fn() => $service->ajukanPeminjaman([
            'Alat_id'                 => $Alat->id,
            'jumlah'                  => 1,
            'tanggal_pinjam'          => now()->addDay()->toDateString(),
            'tanggal_rencana_kembali' => now()->addDays(3)->toDateString(),
        ], $mahasiswa1->id),

        fn() => $service->ajukanPeminjaman([
            'Alat_id'                 => $Alat->id,
            'jumlah'                  => 1,
            'tanggal_pinjam'          => now()->addDay()->toDateString(),
            'tanggal_rencana_kembali' => now()->addDays(3)->toDateString(),
        ], $mahasiswa2->id),
    ];

    foreach ($requests as $request) {
        try {
            $request();
            $berhasil++;
        } catch (\Exception $e) {
            $gagal++;
        }
    }

    // Tepat 1 berhasil, 1 gagal
    expect($berhasil)->toBe(1);
    expect($gagal)->toBe(1);

    // Stok tidak minus
    expect($Alat->fresh()->stok_tersedia)->toBeGreaterThanOrEqual(0);
});

it('throw StokTidakCukupException jika jumlah melebihi stok', function () {
    $mahasiswa = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $Alat = Alat::factory()->create(['total_stok' => 2, 'stok_tersedia' => 2]);

    expect(fn() => (new PeminjamanService())->ajukanPeminjaman([
        'Alat_id'                 => $Alat->id,
        'jumlah'                  => 5, // minta 5, stok hanya 2
        'tanggal_pinjam'          => now()->addDay()->toDateString(),
        'tanggal_rencana_kembali' => now()->addDays(3)->toDateString(),
    ], $mahasiswa->id))
    ->toThrow(\App\Exceptions\StokTidakCukupException::class);

    // Stok tidak berubah karena exception
    expect($Alat->fresh()->stok_tersedia)->toBe(2);
});