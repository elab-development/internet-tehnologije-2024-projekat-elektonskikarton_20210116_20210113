<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pregled;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sestra extends Model
{
    /** @use HasFactory<\Database\Factories\SestraFactory> */
    use HasFactory;
    protected $guarded = [];

    public function pregleds(): HasMany{
        return $this->hasMany(Pregled::class,'sestra_id','id');
    }
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
