<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Terapija extends Model
{
    /** @use HasFactory<\Database\Factories\TerapijaFactory> */
    use HasFactory;

    public function pregleds(): HasMany{
        return $this->hasMany(Pregled::class);
    }
}
