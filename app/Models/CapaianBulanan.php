<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianBulanan extends Model
{
    protected $fillable = [
        'tahun',
        'bulan',
        'target',
        'realisasi',
        'catatan',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'target' => 'decimal:2',
        'realisasi' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }
}
