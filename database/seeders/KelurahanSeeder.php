<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $wilayah = [

            /*
            |--------------------------------------------------------------------------
            | SINJAI BARAT
            |--------------------------------------------------------------------------
            */
            '730701' => [
                'Gunung Perak',
                'Arabika',
                'Bonto Salama',
                'Turungan Baji',
                'Terasa',
                'Bonto Lempangan',
                'Barania',
                'Tassililu',
                'Balakia',
            ],

            /*
            |--------------------------------------------------------------------------
            | SINJAI BORONG
            |--------------------------------------------------------------------------
            */
            '730702' => [
                'Batu Belerang',
                'Biji Nangka',
                'Barambang',
                'Bonto Sinala',
                'Kassi Buleng',
                'Bonto Katute',
                'Bonto Tengnga',
                'Pasir Putih',
            ],

            /*
            |--------------------------------------------------------------------------
            | SINJAI SELATAN
            |--------------------------------------------------------------------------
            */
            '730703' => [
                'Puncak',
                'Songing',
                'Aska',
                'Talle',
                'Palae',
                'Bulukamase',
                'Palangka',
                'Polewali',
                'Alenangka',
                'Gareccing',
                'Sangiaseri',
            ],

            /*
            |--------------------------------------------------------------------------
            | TELLULIMPOE
            |--------------------------------------------------------------------------
            */
            '730704' => [
                'Saotengnga',
                'Kalobba',
                'Tellulimpoe',
                'Lembang Lohe',
                'Suka Maju',
                'Era Baru',
                'Pattongko',
                'Massaile',
                'Samaturue',
                'Bua',
                'Mannanti',
            ],

            /*
            |--------------------------------------------------------------------------
            | SINJAI TIMUR
            |--------------------------------------------------------------------------
            */
            '730705' => [
                'Sanjai',
                'Pattalassang',
                'Panaikang',
                'Saukang',
                'Kampala',
                'Lasiai',
                'Biroro',
                'Kaloling',
                'Pasimarannu',
                'Tongke-Tongke',
                'Salohe',
                'Bongki Lengkese',
                'Samataring',
            ],

            /*
            |--------------------------------------------------------------------------
            | SINJAI TENGAH
            |--------------------------------------------------------------------------
            */
            '730706' => [
                'Kompang',
                'Baru',
                'Saotengnga',
                'Saohiring',
                'Kanrung',
                'Saotanre',
                'Bonto',
                'Mattunreng Tellue',
                'Gantarang',
                'Pattongko',
                'Samaenre',
            ],

            /*
            |--------------------------------------------------------------------------
            | SINJAI UTARA
            |--------------------------------------------------------------------------
            */
            '730707' => [
                'Balangnipa',
                'Bongki',
                'Lappa',
                'Biringere',
                'Alehanuae',
                'Lamatti Rilau',
            ],

            /*
            |--------------------------------------------------------------------------
            | BULUPODDO
            |--------------------------------------------------------------------------
            */
            '730708' => [
                'Lamatti Riattang',
                'Lamatti Riaja',
                'Lamatti Riawang',
                'Bulu Tellue',
                'Duampanuae',
                'Tompo Bulu',
                'Lappa Cinrana',
            ],

            /*
            |--------------------------------------------------------------------------
            | PULAU SEMBILAN
            |--------------------------------------------------------------------------
            */
            '730709' => [
                'Pulau Harapan',
                'Pulau Buhung Pitue',
                'Pulau Padaelo',
                'Pulau Persatuan',
            ],
        ];

        foreach ($wilayah as $kodeKecamatan => $namaWilayah) {

            $kecamatan = Kecamatan::where('kode', $kodeKecamatan)->first();

            if (!$kecamatan) {
                continue;
            }

            foreach ($namaWilayah as $index => $nama) {

                /*
                 * Kode internal SIJUKIR.
                 * Belum dimaksudkan sebagai kode wilayah Dukcapil/BPS.
                 */
                $kodeInternal = $kodeKecamatan . str_pad(
                    $index + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                Kelurahan::updateOrCreate(
                    [
                        'kecamatan_id' => $kecamatan->id,
                        'nama' => $nama,
                    ],
                    [
                        'kode' => $kodeInternal,
                        'status' => true,
                    ]
                );
            }
        }
    }
}