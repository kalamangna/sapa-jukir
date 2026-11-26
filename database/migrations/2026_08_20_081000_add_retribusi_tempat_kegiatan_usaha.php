<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('sumber_pemasukans')->updateOrInsert(
            ['kode' => 'R-TKU'],
            [
                'nama' => 'Retribusi Penyediaan Tempat Kegiatan Usaha',
                'deskripsi' => 'Penyediaan tempat kegiatan usaha berupa pasar, grosir, pertokoan, dan tempat kegiatan usaha lainnya.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('sumber_pemasukans')
            ->where('kode', 'R-TKU')
            ->delete();
    }
};
