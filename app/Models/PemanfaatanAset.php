<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\Auditable;
use App\Models\AuditLog;

class PemanfaatanAset extends Model
{
    use Auditable;

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }
    protected $fillable = [
        'area_aset_id', 'tagihan_id', 'pihak_pemanfaat', 'jenis_kegiatan', 'tanggal_mulai',
        'tanggal_selesai', 'tarif_sewa', 'nilai_sewa', 'status', 'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tarif_sewa' => 'decimal:2',
        'nilai_sewa' => 'decimal:2',
    ];

    public function areaAset(): BelongsTo
    {
        return $this->belongsTo(AreaAset::class);
    }

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }
}