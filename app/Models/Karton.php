<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karton extends Model
{
    /** @use HasFactory<\Database\Factories\KartonFactory> */
    use HasFactory;

    public function pregleds(): HasMany{
        return $this->hasMany(Pregled::class);
    }
    public function ustanova(): BelongsTo{
        return $this->belongsTo(Ustanova::class);
    }

    public function pacijent(): BelongsTo{
        return $this->belongsTo(Pacijent::class);
    }

    public function zaposlenjes(): HasMany{
        return $this->hasMany(Zaposlenje::class);
    }

}
