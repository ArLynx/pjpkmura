<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Realisasi extends Model
{
    use HasFactory;

    protected $fillable = ['indikator_id', 'tahun_id', 'nilai_realisasi', 'status_pencapaian', 'keterangan', 'created_by'];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dataPendukungs()
    {
        return $this->hasMany(DataPendukung::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }
}
