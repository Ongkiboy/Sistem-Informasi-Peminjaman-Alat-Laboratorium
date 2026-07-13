<?php

use App\Http\Controllers\Api\AlatApiController;
use App\Http\Controllers\Api\RiwayatApiController;
use App\Http\Controllers\Api\TokenApiController;
use Illuminate\Support\Facades\Route;

// Prefix semua route API dengan /v1
Route::prefix('v1')->group(function () {

    // Publik — Katalog Alat (tanpa auth)
    Route::get('/alat', [AlatApiController::class, 'indeks'])
        ->name('api.alat.indeks');

    // Auth Token (publik — untuk generate token)
    Route::post('/token', [TokenApiController::class, 'buat'])
        ->name('api.token.buat');

    // Privat — perlu Sanctum token
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
        Route::delete('/token', [TokenApiController::class, 'cabut'])
            ->name('api.token.cabut');

        Route::get('/riwayat', [RiwayatApiController::class, 'indeks'])
            ->name('api.riwayat.indeks');
    });
});