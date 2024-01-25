<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DaftarPemeliharaanResource extends JsonResource
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
            'id_pemeliharaan' => $this->id_pemeliharaan,
            'id_kegiatan_pemeliharaan' => $this->id_kegiatan_pemeliharaan
        ];
    }
}
