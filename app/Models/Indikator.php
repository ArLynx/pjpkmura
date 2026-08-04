<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Indikator extends Model
{
    use HasFactory;

    protected $fillable = [
        'pilar_id',
        'tujuan_strategis',
        'nama_indikator',
        'instansi',
        'nilai_baseline',
        'tahun_baseline',
        'satuan',
        'sumber_data',
        'urutan',
    ];

    public function pilar()
    {
        return $this->belongsTo(Pilar::class);
    }

    public function targets()
    {
        return $this->hasMany(Target::class);
    }

    public function realisasis()
    {
        return $this->hasMany(Realisasi::class);
    }
}