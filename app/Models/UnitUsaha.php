<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\Auditable;
use App\Models\AuditLog;
use App\Models\UnitUsahaHistory;
use Illuminate\Support\Facades\Auth;

class UnitUsaha extends Model
{
    use Auditable;

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
        static::updated(function (self $model): void {
            $tracked = ['penyewa_nama', 'penyewa_identitas', 'kontrak_mulai', 'kontrak_selesai', 'tarif_sewa', 'status'];
            $changes = array_intersect_key($model->getChanges(), array_flip($tracked));
            if ($changes === []) return;

            UnitUsahaHistory::create([
                'unit_usaha_id' => $model->id,
                'diubah_oleh' => Auth::id(),
                'aksi' => 'perubahan_penyewa_kontrak',
                'nilai_lama' => array_intersect_key($model->getOriginal(), array_flip(array_keys($changes))),
                'nilai_baru' => $changes,
            ]);
        });
    }
    protected $fillable = [
        'objek_pendapatan_id', 'kode_unit', 'nama_unit', 'jenis_unit',
        'penyewa_nama', 'penyewa_identitas', 'luas_m2', 'tarif_sewa',
        'kontrak_mulai', 'kontrak_selesai', 'status', 'metadata',
    ];

    protected $casts = [
        'luas_m2' => 'decimal:2',
        'tarif_sewa' => 'decimal:2',
        'kontrak_mulai' => 'date',
        'kontrak_selesai' => 'date',
        'metadata' => 'array',
    ];

    public function objekPendapatan(): BelongsTo { return $this->belongsTo(ObjekPendapatan::class); }
    public function tagihans(): HasMany { return $this->hasMany(Tagihan::class); }
    public function histories(): HasMany { return $this->hasMany(UnitUsahaHistory::class); }
}