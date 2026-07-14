<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\KatalogController;
use Illuminate\Support\Facades\Route;

// =============================================
// ADMIN — Manajemen Inventori Alat
// =============================================
Route::middleware(['auth', 'cek.admin'])->prefix('admin/alat')->name('admin.alat.')->group(function () {

    Route::get('/',          [AlatController::class, 'indeks'])       ->name('indeks');
    Route::get('/tambah',    [AlatController::class, 'tampilkanForm'])->name('tambah');
    Route::post('/',         [AlatController::class, 'simpan'])       ->name('simpan');
    Route::get('/{alat}/edit', [AlatController::class, 'tampilkanEdit'])->name('edit');
    Route::put('/{alat}',    [AlatController::class, 'perbarui'])     ->name('perbarui');
    Route::delete('/{alat}', [AlatController::class, 'hapus'])        ->name('hapus');
});

// =============================================
// MAHASISWA — Katalog Alat
// =============================================
Route::middleware(['auth', 'cek.mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {

    Route::get('/katalog', [KatalogController::class, 'indeks'])->name('katalog');
});