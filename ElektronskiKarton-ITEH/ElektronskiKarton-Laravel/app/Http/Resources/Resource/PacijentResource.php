<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacijentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'user_id' => $this->user_id,
            'jmbg' => $this->jmbg,
            'imePrezimeNZZ' => $this->imePrezimeNZZ,
            'datumRodjenja' => $this->datumRodjenja,
            'ulicaBroj' => $this->ulicaBroj,
            'telefon' => $this->telefon,
            'pol' => $this->pol,
            'bracniStatus' => $this->bracniStatus,
            'mesto_postanskiBroj' => $this->mesto_postanskiBroj,
            'mesto' => new MestoResource($this->whenLoaded('mesto')),
            'karton' => new KartonResource($this->whenLoaded('karton'))
        ];
    }
}
