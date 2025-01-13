<?php

namespace App\Models;

use App\Models\Mesto;
use App\Models\Karton;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class Ustanova extends Model
{
    /** @use HasFactory<\Database\Factories\UstanovaFactory> */
    use HasFactory;
    protected $guarded = [];

    public function mesto(): BelongsTo
    {
        return $this->belongsTo(Mesto::class,'mesto_postanskiBroj','postanskiBroj');
    }
    public function kartons():HasMany
    {
        return $this->hasMany(Karton::class);
    }

    public function scopeWithNaziv(Builder $query, string $naziv):Builder|QueryBuilder
    {
        return $query->where('naziv','like','%'.$naziv.'%');
    }

    public function scopeWithMesto(Builder $query, int $posBroj):Builder|QueryBuilder
    {
        return $query->where('mesto_postanskiBroj',$posBroj);
    }


}
