<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Target extends Model
{
    use HasFactory;

    protected $fillable = ['indikator_id', 'tahun_id', 'nilai_target', 'created_by'];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }
}
