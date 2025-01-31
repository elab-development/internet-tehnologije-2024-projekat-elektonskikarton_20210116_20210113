<?php

namespace App\Models;

use App\Models\Mesto;
use App\Models\Zaposlenje;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Preduzece extends Model
{
    /** @use HasFactory<\Database\Factories\PreduzeceFactory> */
    use HasFactory;
    protected $guarded = [];

    protected $primaryKey = 'registarskiBroj';
    public $incrementing = false;
    protected $keyType = 'integer'; 

    public function zaposlenjes(): HasMany{
        return $this->hasMany(Zaposlenje::class);
    }

    public function mesto(): BelongsTo{
        return $this->belongsTo(Mesto::class, 'mesto_postanskiBroj','postanskiBroj');
    }

    public function scopeWithRegistarskiBroj(Builder $query, int $rb):Builder|QueryBuilder
    {
        return $query->where('registarskiBroj', $rb);
    }

    public function scopeWithNaziv(Builder $query, string $naziv):Builder|QueryBuilder
    {
        return $query->where('naziv','like','%'. $naziv.'%');
    }

    public function scopeWithSifraDelatnosti(Builder $query, int $sd):Builder|QueryBuilder
    {
        return $query->where('sifraDelatnosti', $sd);
    }

}
