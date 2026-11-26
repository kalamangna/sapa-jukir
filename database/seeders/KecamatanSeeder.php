<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $kecamatans = [
            [
                'nama' => 'Sinjai Barat',
                'kode' => '730701',
            ],
            [
                'nama' => 'Sinjai Selatan',
                'kode' => '730702',
            ],
            [
                'nama' => 'Sinjai Timur',
                'kode' => '730703',
            ],
            [
                'nama' => 'Sinjai Tengah',
                'kode' => '730704',
            ],
            [
                'nama' => 'Sinjai Utara',
                'kode' => '730705',
            ],
            [
                'nama' => 'Bulupoddo',
                'kode' => '730706',
            ],
            [
                'nama' => 'Sinjai Borong',
                'kode' => '730707',
            ],
            [
                'nama' => 'Tellu Limpoe',
                'kode' => '730708',
            ],
            [
                'nama' => 'Pulau Sembilan',
                'kode' => '730709',
            ],
        ];

        foreach ($kecamatans as $kecamatan) {
            Kecamatan::updateOrCreate(
                ['nama' => $kecamatan['nama']],
                [
                    'kode' => $kecamatan['kode'],
                    'status' => true,
                ]
            );
        }
    }
}