<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Instansi;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'role', 'instansi_id', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function targets()
    {
        return $this->hasMany(Target::class, 'created_by');
    }

    public function realisasis()
    {
        return $this->hasMany(Realisasi::class, 'created_by');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
