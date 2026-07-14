<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

$riwayat = Auth::user()
    ->peminjaman()
    ->with('alat')
    ->latest()
    ->paginate(10);

return view('mahasiswa.riwayat.indeks', compact('riwayat'));
class RiwayatController extends Controller
{
    //
    
}
