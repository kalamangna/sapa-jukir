<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jukir extends Model
{
    protected $fillable = [
        'kode_jukir',
        'jenis_jukir_id',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kecamatan_id',
        'kelurahan_id',
        'no_hp',
        'foto',
        'foto_ktp',
        'dokumen_pendukung',
        'nomor_kartu',
        'tanggal_terdaftar',
        'tanggal_berakhir',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_terdaftar' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    protected static function booted(): void
    {
        static::created(fn (self $model) => AuditLog::record($model, 'created', null, $model->getAttributes()));
        static::updated(fn (self $model) => AuditLog::record($model, 'updated', $model->getOriginal(), $model->getChanges()));
        static::deleted(fn (self $model) => AuditLog::record($model, 'deleted', $model->getOriginal(), null));
    }

    public function jenisJukir(): BelongsTo
    {
        return $this->belongsTo(JenisJukir::class);
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function penempatanJukirs(): HasMany
    {
        return $this->hasMany(PenempatanJukir::class);
    }
}