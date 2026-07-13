<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeminjamanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->id,
            'alat'                     => new AlatResource($this->whenLoaded('alat')),
            'jumlah'                   => $this->jumlah,
            'tanggal_pinjam'           => $this->tanggal_pinjam?->format('Y-m-d'),
            'tanggal_rencana_kembali'  => $this->tanggal_rencana_kembali?->format('Y-m-d'),
            'tanggal_kembali_aktual'   => $this->tanggal_kembali_aktual?->format('Y-m-d'),
            'status'                   => $this->status,
            'dibuat_pada'              => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
