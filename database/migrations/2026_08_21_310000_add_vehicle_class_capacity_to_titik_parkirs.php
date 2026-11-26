<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->unsignedInteger('kapasitas_mobil_kecil')->nullable()->after('kapasitas_mobil');
            $table->unsignedInteger('kapasitas_mobil_besar')->nullable()->after('kapasitas_mobil_kecil');
        });
    }

    public function down(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->dropColumn(['kapasitas_mobil_kecil', 'kapasitas_mobil_besar']);
        });
    }
};