<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instansi extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function indikators(): HasMany
    {
        return $this->hasMany(Indikator::class);
    }
    
}