<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pilar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'urutan',
    ];

    public function indikators()
    {
        return $this->hasMany(Indikator::class);
    }
}