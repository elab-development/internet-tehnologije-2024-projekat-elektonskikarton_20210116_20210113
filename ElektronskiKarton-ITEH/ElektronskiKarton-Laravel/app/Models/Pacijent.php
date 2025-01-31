<?php

namespace App\Models;

use App\Models\User;
use App\Models\Mesto;
use App\Models\Karton;
use Illuminate\Database\Eloquent\Model;
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
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
