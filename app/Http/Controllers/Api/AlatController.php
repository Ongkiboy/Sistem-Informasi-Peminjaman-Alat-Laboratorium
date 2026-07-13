<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlatResource;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlatController extends Controller
{
            $alat = alat::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('nama_alat', 'like', "%{$request->q}%")
                      ->orWhere('kode_barang', 'like', "%{$request->q}%");
            })
            ->paginate(20);

        return AlatResource::collection($alat);
}
