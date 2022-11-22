<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mapel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jadwal_absens()
    {
        return $this->hasMany(JadwalAbsen::class);
    }
}
