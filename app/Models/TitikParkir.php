<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TitikParkir extends Model
{
    protected $fillable = [
        'kode_titik',
        'nama',
        'alamat',
        'kecamatan_id',
        'kelurahan_id',
        'jenis_parkir_id',
        'sumber_pemasukan_id',
        'latitude',
        'longitude',
        'status',
        'kapasitas_motor',
        'kapasitas_mobil',
        'kapasitas_mobil_kecil',
        'kapasitas_mobil_besar',
        'kapasitas_total',
        'jumlah_unit',
        'luas_m2',
        'nama_pengelola',
        'telepon_pengelola',
        'potensi_harian',
        'potensi_bulanan',
        'jumlah_koordinator',
        'foto',
        'keterangan',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'jumlah_unit' => 'integer',
        'luas_m2' => 'decimal:2',
        'potensi_harian' => 'decimal:2',
        'potensi_bulanan' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function jenisParkir(): BelongsTo
    {
        return $this->belongsTo(JenisParkir::class);
    }

    public function sumberPemasukan(): BelongsTo
    {
        return $this->belongsTo(SumberPemasukan::class);
    }

    public function penempatanJukirs(): HasMany
    {
        return $this->hasMany(PenempatanJukir::class);
    }

    public function targetPendapatans(): HasMany
    {
        return $this->hasMany(TargetPendapatan::class);
    }

    public function okupansiParkirs(): HasMany
    {
        return $this->hasMany(OkupansiParkir::class);
    }
}