<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetPendapatan extends Model
{
    protected $fillable = [
        'sumber_pemasukan_id',
        'objek_pendapatan_id',
        'titik_parkir_id',
        'tahun',
        'bulan',
        'target',
        'catatan',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'target' => 'decimal:2',
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

    public function titikParkir(): BelongsTo
    {
        return $this->belongsTo(TitikParkir::class);
    }

    public function objekPendapatan(): BelongsTo
    {
        return $this->belongsTo(ObjekPendapatan::class);
    }

}