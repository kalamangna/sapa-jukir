<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\Auditable;
use App\Models\AuditLog;

class WajibPajak extends Model
{
    use Auditable;

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }
    protected $fillable = ['nama', 'npwp', 'nik', 'alamat', 'nomor_telepon', 'email', 'status', 'catatan'];

    public function objekPendapatans(): HasMany
    {
        return $this->hasMany(ObjekPendapatan::class);
    }
}