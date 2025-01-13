<?php

namespace App\Models;

use App\Models\Pacijent;
use App\Models\Ustanova;
use App\Models\Preduzece;
use App\Models\Zaposlenje;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mesto extends Model
{
    /** @use HasFactory<\Database\Factories\MestoFactory> */
    use HasFactory;
    protected $guarded = [];

    protected $primaryKey = 'postanskiBroj';
    public $incrementing = false;
    protected $keyType = 'integer'; // Ako koristiš brojeve za 'postanskiBroj'



    public function zaposlenjes(): HasMany{
        return $this->hasMany(Zaposlenje::class);
    }
    public function pacijents(): HasMany{
        return $this->hasMany(Pacijent::class);
    }

    public function ustanovas(): HasMany{
        return $this->hasMany(Ustanova::class);
    }

    public function preduzeces(): HasMany{
        return $this->hasMany(Preduzece::class, 'preduzece_registarskiBroj','registarskiBroj');
    }

    public function scopeWithNaziv(Builder $query, string $naziv):Builder|QueryBuilder
    {
        return $query->where('naziv','like','%'. $naziv.'%');
    }

    public function scopeWithPostanskiBroj(Builder $query, string $pb):Builder|QueryBuilder
    {
        return $query->where('postanskiBroj',$pb);
    }
    

}
