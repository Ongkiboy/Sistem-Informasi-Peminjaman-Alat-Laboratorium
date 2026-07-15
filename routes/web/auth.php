<?php
// routes/web/auth.php — Assignee: Iki
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login',[AuthController::class, 'tampilkanLogin'])->name('login');
Route::post('/login',[AuthController::class,'prosesLogin'])->name('login.proses');

Route::post('/logout',[AuthController::class,'logout'])
    ->name('logout')
    ->middleware('auth');