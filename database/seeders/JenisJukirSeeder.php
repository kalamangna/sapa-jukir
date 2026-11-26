<?php

namespace Database\Seeders;

use App\Models\JenisJukir;
use Illuminate\Database\Seeder;

class JenisJukirSeeder extends Seeder
{
    public function run(): void
    {
        $jenisJukirs = [
            [
                'kode' => 'J01',
                'nama' => 'Petugas Tetap',
                'deskripsi' => 'Petugas yang ditugaskan secara tetap pada lokasi parkir tertentu.',
                'status' => true,
            ],
            [
                'kode' => 'J02',
                'nama' => 'Petugas Tidak Tetap',
                'deskripsi' => 'Petugas yang bertugas berdasarkan kebutuhan atau penugasan tertentu.',
                'status' => true,
            ],
            [
                'kode' => 'J03',
                'nama' => 'Petugas Pengganti',
                'deskripsi' => 'Petugas yang menggantikan petugas lain untuk sementara waktu.',
                'status' => true,
            ],
        ];

        foreach ($jenisJukirs as $jenis) {
            JenisJukir::updateOrCreate(
                ['kode' => $jenis['kode']],
                [
                    'nama' => $jenis['nama'],
                    'deskripsi' => $jenis['deskripsi'],
                    'status' => $jenis['status'],
                ]
            );
        }
    }
}