<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('jenis_parkirs')
            ->where('kode', 'JP-001')
            ->update([
                'kode' => 'R-PJTU',
                'nama' => 'Retribusi Pelayanan Parkir Tepi Jalan Umum',
                'deskripsi' => 'Pemasukan retribusi pelayanan parkir di tepi jalan umum.',
                'status' => true,
                'updated_at' => now(),
            ]);

        $kategori = [
            [
                'kode' => 'R-TKP',
                'nama' => 'Retribusi Tempat Khusus Parkir',
                'deskripsi' => 'Pemasukan retribusi dari tempat khusus parkir.',
            ],
            [
                'kode' => 'R-PJTU',
                'nama' => 'Retribusi Pelayanan Parkir Tepi Jalan Umum',
                'deskripsi' => 'Pemasukan retribusi pelayanan parkir di tepi jalan umum.',
            ],
        ];

        foreach ($kategori as $item) {
            DB::table('jenis_parkirs')->updateOrInsert(
                ['kode' => $item['kode']],
                [
                    'nama' => $item['nama'],
                    'deskripsi' => $item['deskripsi'],
                    'status' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

    }

    public function down(): void
    {
        DB::table('jenis_parkirs')
            ->where('kode', 'R-TKP')
            ->delete();

        DB::table('jenis_parkirs')
            ->where('kode', 'R-PJTU')
            ->update([
                'kode' => 'JP-001',
                'nama' => 'Parkir Tepi Jalan Umum',
                'deskripsi' => null,
                'updated_at' => now(),
            ]);
    }
};
