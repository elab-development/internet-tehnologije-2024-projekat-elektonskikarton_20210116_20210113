<?php

namespace App\Models;

use App\Models\Karton;
use App\Models\Preduzece;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zaposlenje extends Model
{
    /** @use HasFactory<\Database\Factories\ZaposlenjeFactory> */
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = ['redniBroj', 'karton_id'];
   


    public function preduzece(): BelongsTo
    {
        return $this->belongsTo(Preduzece::class, 'preduzece_registarskiBroj', 'registarskiBroj');
    }

    public function karton(): BelongsTo
    {
        return $this->belongsTo(Karton::class);
    }
}
