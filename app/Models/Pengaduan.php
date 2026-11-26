<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'nama',
        'nik',
        'telepon',
        'titik_parkir',
        'lokasi_parkir',
        'jenis',
        'detail',
        'foto',
        'status',
        'dibaca_at',
    ];

    protected $casts = [
        'dibaca_at' => 'datetime',
    ];
}
