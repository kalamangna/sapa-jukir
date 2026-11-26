<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('objek_pendapatans', function (Blueprint $table) {
            $table->string('npwp', 32)->nullable()->after('nomor_identitas');
            $table->string('nop', 64)->nullable()->after('npwp');
            $table->date('masa_pajak_mulai')->nullable()->after('nop');
            $table->date('masa_pajak_sampai')->nullable()->after('masa_pajak_mulai');
            $table->decimal('tarif_pajak', 5, 2)->nullable()->after('masa_pajak_sampai');
        });
    }

    public function down(): void
    {
        Schema::table('objek_pendapatans', function (Blueprint $table) {
            $table->dropColumn([
                'npwp',
                'nop',
                'masa_pajak_mulai',
                'masa_pajak_sampai',
                'tarif_pajak',
            ]);
        });
    }
};