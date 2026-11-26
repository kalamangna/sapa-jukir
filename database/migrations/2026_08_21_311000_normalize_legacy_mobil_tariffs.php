<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tarifs')->where('jenis_kendaraan', 'mobil')->update(['jenis_kendaraan' => 'mobil_kecil']);
    }

    public function down(): void
    {
        DB::table('tarifs')->where('jenis_kendaraan', 'mobil_kecil')->update(['jenis_kendaraan' => 'mobil']);
    }
};