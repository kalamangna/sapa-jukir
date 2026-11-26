<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Pengaduan extends Model
{
    protected $fillable = [
        'nama',
        'nik',
        'telepon',
        'titik_parkir',
        'lokasi_parkir',
        'jenis',
        'detail',
        'foto',
        'status',
        'dibaca_at',
    ];

    protected $casts = [
        'dibaca_at' => 'datetime',
    ];

    protected function nik(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): ?string {
                if (blank($value)) {
                    return null;
                }

                try {
                    return Crypt::decryptString($value);
                } catch (DecryptException) {
                    // Tetap tampilkan data NIK lama yang tersimpan polos sebelum enkripsi diterapkan.
                    return $value;
                }
            },
            set: fn (?string $value): ?string => blank($value)
                ? null
                : Crypt::encryptString((string) $value),
        );
    }
}
