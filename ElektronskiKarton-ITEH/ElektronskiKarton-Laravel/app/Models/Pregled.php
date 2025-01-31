<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pregled extends Model
{
    /** @use HasFactory<\Database\Factories\PregledFactory> */
    use HasFactory;
    protected $guarded = [];


    public function karton(): BelongsTo{
        return $this->belongsTo(Karton::class);
    }
    public function doktor(): BelongsTo{
        return $this->belongsTo(Doktor::class);
    }
    public function dijagnoza(): BelongsTo{
        return $this->belongsTo(Dijagnoza::class);
    }
    public function terapija(): BelongsTo{
        return $this->belongsTo(Terapija::class);
    }
    public function sestra(): BelongsTo{
        return $this->belongsTo(Sestra::class);
    }
}
