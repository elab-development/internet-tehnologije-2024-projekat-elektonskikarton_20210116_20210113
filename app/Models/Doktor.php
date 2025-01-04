<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doktor extends Model
{
    /** @use HasFactory<\Database\Factories\DoktorFactory> */
    use HasFactory;
    protected $guarded = [];


    public function pregleds(): HasMany{
        return $this->hasMany(Pregled::class,'doktor_id','id');
    }
}
