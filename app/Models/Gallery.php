<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public const CATEGORIES = [
        'Pembagian Aksesoris',
        'Rapat & Kunjungan',
        'Razia Jukir',
        'Sosialisasi',
        'SP & Tipiring',
        'Uji Petik',
        'Lainnya',
    ];

    protected $fillable = [
        'judul',
        'kategori',
        'tanggal_kegiatan',
        'gallery_group',
        'deskripsi',
        'gambar',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'tanggal_kegiatan' => 'date',
    ];
}
