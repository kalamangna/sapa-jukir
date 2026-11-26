<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setoran extends Model
{
    use HasFactory;

    protected $table = 'setorans';

    protected $fillable = [
        'sumber_pemasukan_id',
        'objek_pendapatan_id',
        'jukir_id',
        'titik_parkir_id',
        'tanggal',
        'jumlah_motor',
        'jumlah_mobil',
        'jumlah_mobil_kecil',
        'jumlah_mobil_besar',
        'karcis_nomor',
        'jumlah_karcis',
        'pendapatan_bruto',
        'jumlah_setoran',
        'selisih',
        'status',
        'keterangan',
        'diverifikasi_at',
        'diverifikasi_oleh',
    ];


    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',

            'jumlah_motor' => 'integer',

            'jumlah_mobil' => 'integer',
            'jumlah_mobil_kecil' => 'integer',
            'jumlah_mobil_besar' => 'integer',
            'jumlah_karcis' => 'integer',

            'pendapatan_bruto' => 'decimal:2',

            'jumlah_setoran' => 'decimal:2',

            'selisih' => 'decimal:2',

            'diverifikasi_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::created(fn (self $setoran) => AuditLog::record($setoran, 'created', null, $setoran->getAttributes()));
        static::updated(fn (self $setoran) => AuditLog::record($setoran, 'updated', $setoran->getOriginal(), $setoran->getChanges()));
        static::deleted(fn (self $setoran) => AuditLog::record($setoran, 'deleted', $setoran->getOriginal(), null));
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI JUKIR
    |--------------------------------------------------------------------------
    */

    public function jukir(): BelongsTo
    {
        return $this->belongsTo(
            Jukir::class,
            'jukir_id'
        );
    }

    public function sumberPemasukan(): BelongsTo
    {
        return $this->belongsTo(SumberPemasukan::class);
    }

    public function karcisUsages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KarcisUsage::class);
    }

    public function objekPendapatan(): BelongsTo
    {
        return $this->belongsTo(ObjekPendapatan::class);
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI TITIK PARKIR
    |--------------------------------------------------------------------------
    */

    public function titikParkir(): BelongsTo
    {
        return $this->belongsTo(
            TitikParkir::class,
            'titik_parkir_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI USER VERIFIKATOR
    |--------------------------------------------------------------------------
    */

    public function diverifikasiOleh(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'diverifikasi_oleh'
        );
    }
}