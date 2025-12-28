<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nama_event'    => $this->nama_event,
            'tanggal_event' => $this->tanggal_event,
            'deskripsi'     => $this->deskripsi,
            'kategori'      => $this->whenLoaded('category', function() {
                return $this->category->nama_kategori;
            }),
            'lokasi'        => $this->whenLoaded('venue', function() {
                return [
                    'nama_venue' => $this->venue->nama_venue,
                    'gedung'     => $this->venue->gedung,
                ];
            }),
        ];
    }
}
