<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ObjekPendapatan extends Model
{
    protected $fillable = [
        'sumber_pemasukan_id',
        'kode',
        'nama',
        'tipe',
        'alamat',
        'nama_pengelola',
        'nomor_identitas',
        'jenis_usaha',
        'jenis_aset',
        'nomor_aset',
        'luas_m2',
        'tarif_sewa',
        'nomor_kontrak',
        'kontrak_mulai',
        'kontrak_selesai',
        'potensi_harian',
        'potensi_bulanan',
        'status',
        'metadata',
    ];

    protected $casts = [
        'potensi_harian' => 'decimal:2',
        'potensi_bulanan' => 'decimal:2',
        'masa_pajak_mulai' => 'date',
        'masa_pajak_sampai' => 'date',
        'tarif_pajak' => 'decimal:2',
        'luas_m2' => 'decimal:2',
        'tarif_sewa' => 'decimal:2',
        'kontrak_mulai' => 'date',
        'kontrak_selesai' => 'date',
        'metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }

    public function sumberPemasukan(): BelongsTo
    {
        return $this->belongsTo(SumberPemasukan::class);
    }

    public function setorans(): HasMany
    {
        return $this->hasMany(Setoran::class);
    }

    public function targetPendapatans(): HasMany
    {
        return $this->hasMany(TargetPendapatan::class);
    }

    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }

    public function unitUsahas(): HasMany
    {
        return $this->hasMany(UnitUsaha::class);
    }
}