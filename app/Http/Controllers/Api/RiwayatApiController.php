<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeminjamanResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RiwayatApiController extends Controller
{
    public function indeks(Request $request): AnonymousResourceCollection
    {
        $riwayat = $request->user()
            ->peminjaman()
            ->with('alat')
            ->latest()
            ->paginate(10);

        return PeminjamanResource::collection($riwayat);
    }
}