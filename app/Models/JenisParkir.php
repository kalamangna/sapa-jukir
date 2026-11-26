<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisParkir extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }

    public function titikParkirs(): HasMany
    {
        return $this->hasMany(TitikParkir::class);
    }

    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class);
    }
}