<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    public function indeks(Request $request): View
    {
        $alat = Alat::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('nama_alat', 'like', "%{$request->q}%")
                      ->orWhere('kode_barang', 'like', "%{$request->q}%");
            })
            ->orderBy('nama_alat') // urutan default: A-Z
            ->paginate(20)
            ->withQueryString();

        return view('mahasiswa.katalog.indeks', compact('alat'));
    }
}