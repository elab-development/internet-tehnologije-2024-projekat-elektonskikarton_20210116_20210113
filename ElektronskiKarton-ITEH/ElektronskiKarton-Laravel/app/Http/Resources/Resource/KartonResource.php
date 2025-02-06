<?php

namespace App\Http\Resources\Resource;

use App\Models\Zaposlenje;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KartonResource extends JsonResource
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
            'brojKnjizice' => $this->brojKnjizice,
            'napomene' => $this->napomene,
            'pacijent_jmbg' => $this->pacijent_jmbg,
            'pregledi' => PregledResource::collection($this->whenLoaded('pregleds')),
            'ustanova' => new UstanovaResource($this->whenLoaded('ustanova')),
            'zaposlenje' => ZaposlenjeResource::collection($this->whenLoaded('zaposlenjes'))
        ];
    }
}
