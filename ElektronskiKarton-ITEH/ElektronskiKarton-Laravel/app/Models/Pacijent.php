<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pacijent extends Model
{
    /** @use HasFactory<\Database\Factories\PacijentFactory> */
    use HasFactory;

    protected $primaryKey = "jmbg";
    public $incrementing = false;
    protected $keyType = "string";

    protected $guarded = [];


    public function mesto(): BelongsTo{
        return $this->belongsTo(Mesto::class);
    }

    public function karton(): BelongsTo{
        return $this->belongsTo(Karton::class);
    }

}
