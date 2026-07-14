<?php

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use App\Services\PeminjamanService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = app(PeminjamanService::class);
});

// ─────────────────────────────────────────────────────────────────────────────
//TEST-004: tolakPeminjaman() — stok harus kembali dengan benar
// ─────────────────────────────────────────────────────────────────────────────

it('mengembalikan stok saat pengajuan ditolak', function () {
    // Arrange
    $alat = Alat::factory()->create([
        'total_stok'    => 10,
        'stok_tersedia' => 7,   // 3 unit sedang dalam proses pending
    ]);

    $mahasiswa = Pengguna::factory()->create(['role' => 'mahasiswa']);

    $peminjaman = Peminjaman::factory()->create([
        'alat_id'      => $alat->id,
        'pengguna_id'  => $mahasiswa->id,
        'jumlah'       => 3,
        'status'       => 'pending',
    ]);

    // Act
    $this->service->tolakPeminjaman($peminjaman);

    // Assert
    expect($peminjaman->fresh()->status)->toBe('rejected');
    expect($peminjaman->fresh()->ditolak_pada)->not->toBeNull();

    // Stok harus kembali: 7 + 3 = 10
    expect($alat->fresh()->stok_tersedia)->toBe(10);
});

it('status berubah menjadi rejected setelah ditolak', function () {
    $alat = Alat::factory()->create([
        'total_stok'    => 5,
        'stok_tersedia' => 3,
    ]);
    $mahasiswa  = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $peminjaman = Peminjaman::factory()->create([
        'alat_id'     => $alat->id,
        'pengguna_id' => $mahasiswa->id,
        'jumlah'      => 2,
        'status'      => 'pending',
    ]);

    $this->service->tolakPeminjaman($peminjaman);

    expect($peminjaman->fresh()->status)->toBe('rejected');
});

it('tidak bisa tolak pengajuan yang bukan pending', function () {
    $alat = Alat::factory()->create();
    $mahasiswa  = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $peminjaman = Peminjaman::factory()->create([
        'alat_id'     => $alat->id,
        'pengguna_id' => $mahasiswa->id,
        'jumlah'      => 1,
        'status'      => 'approved', // bukan pending
    ]);

    expect(fn () => $this->service->tolakPeminjaman($peminjaman))
        ->toThrow(\Exception::class);
});

// ─────────────────────────────────────────────────────────────────────────────
//TEST-005: konfirmasiPengembalian() — guard stok tidak melebihi total
// ─────────────────────────────────────────────────────────────────────────────

it('stok tidak melebihi total_stok saat konfirmasi pengembalian', function () {
    // Simulasi edge case: stok_tersedia sudah 9, dikembalikan 3 → harusnya cap di total_stok=10
    $alat = Alat::factory()->create([
        'total_stok'    => 10,
        'stok_tersedia' => 9,   // sudah hampir penuh
    ]);

    $mahasiswa  = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $peminjaman = Peminjaman::factory()->create([
        'alat_id'     => $alat->id,
        'pengguna_id' => $mahasiswa->id,
        'jumlah'      => 3,
        'status'      => 'borrowed',
    ]);

    $this->service->konfirmasiPengembalian($peminjaman);

    // Stok harusnya cap di 10, bukan 9+3=12
    expect($alat->fresh()->stok_tersedia)->toBe(10);
});

it('status berubah menjadi returned dan tanggal_kembali_aktual terisi', function () {
    $alat = Alat::factory()->create([
        'total_stok'    => 5,
        'stok_tersedia' => 2,
    ]);
    $mahasiswa  = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $peminjaman = Peminjaman::factory()->create([
        'alat_id'     => $alat->id,
        'pengguna_id' => $mahasiswa->id,
        'jumlah'      => 2,
        'status'      => 'borrowed',
    ]);

    $this->service->konfirmasiPengembalian($peminjaman);

    expect($peminjaman->fresh()->status)->toBe('returned');
    expect($peminjaman->fresh()->tanggal_kembali_aktual)->not->toBeNull();
});

it('tidak bisa konfirmasi pengembalian jika bukan status borrowed', function () {
    $alat = Alat::factory()->create();
    $mahasiswa  = Pengguna::factory()->create(['role' => 'mahasiswa']);
    $peminjaman = Peminjaman::factory()->create([
        'alat_id'     => $alat->id,
        'pengguna_id' => $mahasiswa->id,
        'jumlah'      => 1,
        'status'      => 'approved', // bukan borrowed
    ]);

    expect(fn () => $this->service->konfirmasiPengembalian($peminjaman))
        ->toThrow(\Exception::class);
});