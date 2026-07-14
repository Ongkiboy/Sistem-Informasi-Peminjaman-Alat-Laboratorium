<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\KatalogController;
use Illuminate\Support\Facades\Route;

// Root redirect ke login
Route::redirect('/', '/login');

// Include route per modul
require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/alat.php';
require __DIR__ . '/web/peminjaman.php';
require __DIR__ . '/web/approval.php';