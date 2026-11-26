<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('jenis_jukirs')->where('kode', 'J01')->update([
            'nama' => 'Petugas Tetap',
            'deskripsi' => 'Petugas yang ditugaskan secara tetap pada lokasi parkir tertentu.',
            'updated_at' => now(),
        ]);

        DB::table('jenis_jukirs')->where('kode', 'J02')->update([
            'nama' => 'Petugas Tidak Tetap',
            'deskripsi' => 'Petugas yang bertugas berdasarkan kebutuhan atau penugasan tertentu.',
            'updated_at' => now(),
        ]);

        DB::table('jenis_jukirs')->where('kode', 'J03')->update([
            'nama' => 'Petugas Pengganti',
            'deskripsi' => 'Petugas yang menggantikan petugas lain untuk sementara waktu.',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('jenis_jukirs')->where('kode', 'J01')->update(['nama' => 'Jukir Tetap']);
        DB::table('jenis_jukirs')->where('kode', 'J02')->update(['nama' => 'Jukir Tidak Tetap']);
        DB::table('jenis_jukirs')->where('kode', 'J03')->update(['nama' => 'Jukir Pengganti']);
    }
};