<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Preduzece extends Model
{
    /** @use HasFactory<\Database\Factories\PreduzeceFactory> */
    use HasFactory;

    public function zaposlenjes(): HasMany{
        return $this->hasMany(Zaposlenje::class);
    }

    public function mesto(): BelongsTo{
        return $this->belongsTo(Mesto::class);
    }
}
