<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\Auditable;
use App\Models\AuditLog;

class AsetDaerah extends Model
{
    use Auditable;

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }
    protected $fillable = ['kode_aset', 'nama_aset', 'jenis_aset', 'lokasi', 'nomor_register', 'luas_total_m2', 'status', 'keterangan'];

    protected $casts = ['luas_total_m2' => 'decimal:2'];

    public function areaAsets(): HasMany
    {
        return $this->hasMany(AreaAset::class);
    }
}