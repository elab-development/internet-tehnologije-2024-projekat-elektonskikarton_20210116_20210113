<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mesto extends Model
{
    /** @use HasFactory<\Database\Factories\MestoFactory> */
    use HasFactory;
    protected $guarded = [];


    public function zaposlenjes(): HasMany{
        return $this->hasMany(Zaposlenje::class);
    }
    public function pacijents(): HasMany{
        return $this->hasMany(Pacijent::class);
    }

    public function ustanovas(): HasMany{
        return $this->hasMany(Ustanova::class);
    }

    public function preduzeces(): HasMany{
        return $this->hasMany(Preduzece::class, 'preduzece_registarskiBroj','registarskiBroj');
    }
}
