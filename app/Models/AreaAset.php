<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\Auditable;
use App\Models\AuditLog;

class AreaAset extends Model
{
    use Auditable;

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }
    protected $fillable = ['aset_daerah_id', 'kode_area', 'nama_area', 'luas_m2', 'tarif_sewa', 'status', 'pemanfaat_terakhir', 'keterangan'];

    protected $casts = ['luas_m2' => 'decimal:2', 'tarif_sewa' => 'decimal:2'];

    public function asetDaerah(): BelongsTo
    {
        return $this->belongsTo(AsetDaerah::class);
    }

    public function pemanfaatanAsets(): HasMany
    {
        return $this->hasMany(PemanfaatanAset::class);
    }
}