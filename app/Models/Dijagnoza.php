<?php

namespace App\Models;

use App\Models\Pregled;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    
    public function scopeWithNaziv(Builder $query, string $naziv):Builder|QueryBuilder
    {
        return $query->where('naziv','like','%'.$naziv.'%');
    }
    

}
