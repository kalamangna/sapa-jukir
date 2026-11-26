<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitUsahaHistory extends Model
{
    protected $fillable = ['unit_usaha_id', 'diubah_oleh', 'aksi', 'nilai_lama', 'nilai_baru'];
    protected $casts = ['nilai_lama' => 'array', 'nilai_baru' => 'array'];
    public function unitUsaha(): BelongsTo { return $this->belongsTo(UnitUsaha::class); }
    public function diubahOleh(): BelongsTo { return $this->belongsTo(User::class, 'diubah_oleh'); }
}