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
            'brojKnjizice' => $this->brojKnjizice,
            'napomene' => $this->napomene,
            'pacijent_jmbg' => $this->pacijent_jmbg,
            'ustanova' => new UstanovaResource($this->whenLoaded('ustanova')),
            'zaposlenje' => Zaposlenje::collection($this->whenLoadded('zaposlenjes'))
        ];
    }
}
