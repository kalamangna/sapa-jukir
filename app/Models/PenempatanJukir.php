<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenempatanJukir extends Model
{
    protected $fillable = [
        'jukir_id',
        'titik_parkir_id',
        'role',
        'target_per_hari',
        'waktu_kerja',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'surat_penugasan',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
    
    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }

    public function jukir(): BelongsTo
    {
        return $this->belongsTo(Jukir::class);
    }

    public function titikParkir(): BelongsTo
    {
        return $this->belongsTo(TitikParkir::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}