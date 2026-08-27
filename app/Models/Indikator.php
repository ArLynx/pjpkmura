<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Instansi;

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
        'instansi_id',
        'instansi_pendukung',
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

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }
}
