<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->unsignedInteger('kapasitas_total')->nullable()->after('kapasitas_mobil');
            $table->string('nama_pengelola')->nullable()->after('kapasitas_total');
            $table->string('telepon_pengelola', 30)->nullable()->after('nama_pengelola');
        });
    }

    public function down(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->dropColumn(['kapasitas_total', 'nama_pengelola', 'telepon_pengelola']);
        });
    }
};