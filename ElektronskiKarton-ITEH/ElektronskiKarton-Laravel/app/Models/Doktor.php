<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pregled;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Doktor extends Model
{
    /** @use HasFactory<\Database\Factories\DoktorFactory> */
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function pregleds(): HasMany{
        return $this->hasMany(Pregled::class,'doktor_id','id');
    }

    public function scopeWithSpecijalizacija(Builder $query, string $spec):Builder|QueryBuilder
    {
        return $query->where('specijalizacija','like','%'.$spec.'%');
    }
    
}
