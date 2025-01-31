<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PreduzeceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'registarskiBroj' => $this->registarskiBroj,
            'naziv' => $this->naziv,
            'sifraDelatnosti' => $this->sifraDelatnosti,
            'mesto' => new MestoResource($this->whenLoaded('mesto'))
        ];
    }
}
