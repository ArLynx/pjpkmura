<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendukung extends Model
{
    use HasFactory;

    protected $fillable = [
        'realisasi_id',
        'judul',
        'file',
    ];

    public function realisasi()
    {
        return $this->belongsTo(Realisasi::class);
    }
}