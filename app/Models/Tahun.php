<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $fillable = [

        'tahun',

        'status',

    ];

    public function targets()
    {
        return $this->hasMany(Target::class);
    }

    public function realisasis()
    {
        return $this->hasMany(Realisasi::class);
    }
}
