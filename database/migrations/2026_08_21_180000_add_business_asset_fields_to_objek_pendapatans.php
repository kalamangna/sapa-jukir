<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('objek_pendapatans', function (Blueprint $table) {
            $table->decimal('luas_m2', 12, 2)->nullable()->after('nomor_aset');
            $table->decimal('tarif_sewa', 15, 2)->nullable()->after('luas_m2');
            $table->string('nomor_kontrak', 100)->nullable()->after('tarif_sewa');
            $table->date('kontrak_mulai')->nullable()->after('nomor_kontrak');
            $table->date('kontrak_selesai')->nullable()->after('kontrak_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('objek_pendapatans', function (Blueprint $table) {
            $table->dropColumn(['luas_m2', 'tarif_sewa', 'nomor_kontrak', 'kontrak_mulai', 'kontrak_selesai']);
        });
    }
};