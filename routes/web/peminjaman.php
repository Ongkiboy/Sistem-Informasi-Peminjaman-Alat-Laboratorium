<?php
// routes/web/peminjaman.php — Assignee: Teman 2

use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'cek.mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/peminjaman/{alat}', [PeminjamanController::class, 'tampilkanForm'])
        ->name('peminjaman.form');
    Route::post('/peminjaman', [PeminjamanController::class, 'ajukan'])
        ->name('peminjaman.ajukan');
    Route::get('/riwayat', [RiwayatController::class, 'indeks'])
        ->name('riwayat');
});
