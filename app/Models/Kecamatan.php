<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function kelurahans(): HasMany
    {
        return $this->hasMany(Kelurahan::class);
    }

    public function jukirs(): HasMany
    {
        return $this->hasMany(Jukir::class);
    }

    public function titikParkirs(): HasMany
    {
        return $this->hasMany(TitikParkir::class);
    }
}