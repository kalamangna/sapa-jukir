<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sambutan extends Model
{
    protected $fillable = [
        'nama_kepala_dinas',
        'jabatan',
        'nama_sekda',
        'jabatan_sekda',
        'deskripsi',
        'foto',
        'foto_kadis',
        'foto_sekda',
        'background_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
