<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\Auditable;
use App\Models\AuditLog;

class Tagihan extends Model
{
    use Auditable;

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }
    protected $fillable = [
        'sumber_pemasukan_id', 'objek_pendapatan_id', 'unit_usaha_id', 'nomor_tagihan',
        'pihak_tertagih', 'uraian', 'tanggal_terbit', 'tanggal_jatuh_tempo',
        'nilai_tagihan', 'status', 'catatan',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'nilai_tagihan' => 'decimal:2',
    ];

    protected $appends = ['total_dibayar', 'sisa_tagihan', 'terlambat'];

    public function sumberPemasukan(): BelongsTo { return $this->belongsTo(SumberPemasukan::class); }
    public function objekPendapatan(): BelongsTo { return $this->belongsTo(ObjekPendapatan::class); }
    public function unitUsaha(): BelongsTo { return $this->belongsTo(UnitUsaha::class); }
    public function pembayarans(): HasMany { return $this->hasMany(Pembayaran::class); }

    public function getTotalDibayarAttribute(): float
    {
        return (float) $this->pembayarans()->sum('jumlah_bayar');
    }

    public function getSisaTagihanAttribute(): float
    {
        return max(0, (float) $this->nilai_tagihan - $this->total_dibayar);
    }

    public function getTerlambatAttribute(): bool
    {
        return $this->sisa_tagihan > 0 && $this->tanggal_jatuh_tempo?->isPast();
    }
}