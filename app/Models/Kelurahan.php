<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelurahan extends Model
{
    protected $fillable = [
        'kecamatan_id',
        'kode',
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
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