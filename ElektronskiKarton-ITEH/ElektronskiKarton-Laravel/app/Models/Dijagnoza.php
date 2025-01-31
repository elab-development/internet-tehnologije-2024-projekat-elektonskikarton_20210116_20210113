<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dijagnoza extends Model
{
    /** @use HasFactory<\Database\Factories\DijagnozaFactory> */
    use HasFactory;
    protected $guarded = [];

    public function pregleds(): HasMany
    {
        return $this->hasMany(Pregled::class,'dijagnoza_id','id');
    }
}
