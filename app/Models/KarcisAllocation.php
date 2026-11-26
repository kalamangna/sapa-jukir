<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KarcisAllocation extends Model
{
    protected $fillable = [
        'sumber_pemasukan_id',
        'jukir_id',
        'penerima',
        'jenis_karcis',
        'seri_prefix',
        'nomor_awal',
        'nomor_akhir',
        'lebar_nomor',
        'nilai_per_karcis',
        'tanggal_penyerahan',
    ];

    protected function casts(): array
    {
        return [
            'nomor_awal' => 'integer',
            'nomor_akhir' => 'integer',
            'lebar_nomor' => 'integer',
            'nilai_per_karcis' => 'integer',
            'tanggal_penyerahan' => 'date',
        ];
    }

    public function sumberPemasukan(): BelongsTo
    {
        return $this->belongsTo(SumberPemasukan::class);
    }

    public function jukir(): BelongsTo
    {
        return $this->belongsTo(Jukir::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(KarcisUsage::class, 'karcis_allocation_id');
    }

    public function formatNomor(int $number): string
    {
        return $this->seri_prefix . str_pad((string) $number, $this->lebar_nomor, '0', STR_PAD_LEFT);
    }

    public function getJumlahTersediaAttribute(): int
    {
        return max(0, $this->nomor_akhir - $this->nomor_awal + 1 - $this->usages_count);
    }
}
