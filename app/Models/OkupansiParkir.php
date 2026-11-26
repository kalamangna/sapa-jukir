<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OkupansiParkir extends Model
{
    protected $fillable = ['titik_parkir_id', 'tanggal', 'jumlah_motor', 'jumlah_mobil', 'catatan'];

    protected $casts = ['tanggal' => 'date', 'jumlah_motor' => 'integer', 'jumlah_mobil' => 'integer'];

    public function titikParkir(): BelongsTo { return $this->belongsTo(TitikParkir::class); }

    public function getJumlahKendaraanAttribute(): int
    {
        return $this->jumlah_motor + $this->jumlah_mobil;
    }
}