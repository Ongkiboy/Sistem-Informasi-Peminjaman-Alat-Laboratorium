<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'nama_alat' => $this->nama_alat,
            'kode_barang' => $this->kode_barang,
            'kondisi' => $this->kondisi,
            'stok_tersedia' => $this->stok_tersedia
        ];
    }
}
