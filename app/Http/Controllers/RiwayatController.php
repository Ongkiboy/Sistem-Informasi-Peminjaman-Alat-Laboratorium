<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    public function indeks(): View
    {
        $riwayat = Auth::user()
            ->peminjaman()
            ->with('alat')
            ->latest()
            ->paginate(10);

        return view('mahasiswa.riwayat.indeks', compact('riwayat'));
    }
}
