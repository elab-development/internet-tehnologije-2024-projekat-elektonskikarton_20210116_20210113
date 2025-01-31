<?php

namespace App\Models;

use App\Models\Mesto;
use App\Models\Karton;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
