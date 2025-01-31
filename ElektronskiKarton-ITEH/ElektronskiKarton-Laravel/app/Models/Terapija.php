<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class Terapija extends Model
{
    /** @use HasFactory<\Database\Factories\TerapijaFactory> */
    use HasFactory;
    protected $guarded = [];


    public function pregleds(): HasMany{
        return $this->hasMany(Pregled::class,'terapija_id','id');
    }
    public function scopeWithNaziv(Builder $query, string $naziv):Builder|QueryBuilder
    {
        return $query->where('naziv','like','%'.$naziv.'%');
    }
}
