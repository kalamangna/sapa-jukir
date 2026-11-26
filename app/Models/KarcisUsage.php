<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KarcisUsage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'karcis_allocation_id',
        'setoran_id',
        'nomor_seri',
    ];

    protected function casts(): array
    {
        return [
            'nomor_seri' => 'integer',
        ];
    }

    public function allocation(): BelongsTo
    {
        return $this->belongsTo(KarcisAllocation::class, 'karcis_allocation_id');
    }

    public function setoran(): BelongsTo
    {
        return $this->belongsTo(Setoran::class);
    }
}
