<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeringatanCapaian extends Model
{
    protected $fillable = [
        'sumber_pemasukan_id', 'titik_parkir_id', 'objek_pendapatan_id',
        'tahun', 'bulan', 'scope', 'judul', 'target', 'realisasi',
        'persentase', 'status', 'catatan', 'ditindaklanjuti_oleh', 'ditindaklanjuti_at',
    ];

    protected $casts = [
        'tahun' => 'integer', 'bulan' => 'integer', 'target' => 'decimal:2',
        'realisasi' => 'decimal:2', 'persentase' => 'decimal:2', 'ditindaklanjuti_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(fn (self $peringatan) => AuditLog::record($peringatan, 'created', null, $peringatan->getAttributes()));
        static::updated(fn (self $peringatan) => AuditLog::record($peringatan, 'updated', $peringatan->getOriginal(), $peringatan->getChanges()));
        static::deleted(fn (self $peringatan) => AuditLog::record($peringatan, 'deleted', $peringatan->getOriginal(), null));
    }

    public function sumberPemasukan(): BelongsTo { return $this->belongsTo(SumberPemasukan::class); }
    public function titikParkir(): BelongsTo { return $this->belongsTo(TitikParkir::class); }
    public function objekPendapatan(): BelongsTo { return $this->belongsTo(ObjekPendapatan::class); }
    public function ditindaklanjutiOleh(): BelongsTo { return $this->belongsTo(User::class, 'ditindaklanjuti_oleh'); }
}