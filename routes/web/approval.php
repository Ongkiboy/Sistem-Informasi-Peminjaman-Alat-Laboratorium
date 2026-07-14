<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// =============================================
// ADMIN — Dashboard
// =============================================
Route::middleware(['auth', 'cek.admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'indeks'])
        ->name('admin.dashboard');
});

// =============================================
// ADMIN — Approval & Pengembalian
// =============================================
Route::middleware(['auth', 'cek.admin'])->prefix('admin/approval')->name('admin.approval.')->group(function () {

    Route::get('/',                         [ApprovalController::class, 'indeks']) ->name('indeks');
    Route::post('/{peminjaman}/setujui',    [ApprovalController::class, 'setujui'])->name('setujui');
    Route::post('/{peminjaman}/tolak',      [ApprovalController::class, 'tolak'])  ->name('tolak');
    Route::post('/{peminjaman}/diambil',    [ApprovalController::class, 'diambil'])->name('diambil');
    Route::post('/{peminjaman}/kembali',    [ApprovalController::class, 'kembali'])->name('kembali');
});