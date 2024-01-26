<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangInventarisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'kategori_pemeliharaan' => $this->kategori_pemeliharaan,
            'pemeliharaan' => collect($this->pemeliharaan)->map(function($pemeliharaan) {
                return [
                    'id' => $pemeliharaan->id,
                    'tanggal' => $pemeliharaan->tanggal,
                    'catatan' => $pemeliharaan->catatan,
                ];
            }),

        ];
    }
}
