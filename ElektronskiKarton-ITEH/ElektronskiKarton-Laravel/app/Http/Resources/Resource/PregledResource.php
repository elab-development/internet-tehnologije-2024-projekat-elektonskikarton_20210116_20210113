<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PregledResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'redniBroj'=> $this->redniBroj,
            'datum' => $this->datum,
            'doktor' => new DoktorResource($this->whenLoaded('doktor')),
            'sestra' => new SestraResource($this->whenLoaded('sestra')),
            'terapija' => new TerapijaResource($this->whenLoaded('terapija')),
            'karton' => new KartonResource($this->whenLoaded('karton')),
            'dijagnoza' => new DijagnozaResource($this->whenLoaded('dijagnoza')),
        ];
    }
}
