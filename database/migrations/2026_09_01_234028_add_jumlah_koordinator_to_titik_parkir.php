<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->tinyInteger('jumlah_koordinator')->default(1)->after('potensi_bulanan')
                ->comment('Jumlah koordinator/regu yang diperbolehkan di titik parkir ini (1 atau 2)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->dropColumn('jumlah_koordinator');
        });
    }
};
