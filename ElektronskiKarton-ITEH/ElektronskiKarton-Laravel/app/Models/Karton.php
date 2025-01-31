<?php

namespace App\Models;

use App\Models\Pregled;
use App\Models\Pacijent;
use App\Models\Ustanova;
use App\Models\Zaposlenje;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karton extends Model
{
    /** @use HasFactory<\Database\Factories\KartonFactory> */
    use HasFactory;
    protected $guarded = [];


    public function pregleds(): HasMany{
        return $this->hasMany(Pregled::class,'karton_id','id');
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

    public function scopeWithBrojKnjizice(Builder $query, string $bk):Builder|QueryBuilder
    {
        return $query->where('brojKnjizice','like',$bk);
    }

}
