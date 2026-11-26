<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_mobil_kecil')->nullable()->after('jumlah_mobil');
            $table->unsignedInteger('jumlah_mobil_besar')->nullable()->after('jumlah_mobil_kecil');
        });
    }

    public function down(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->dropColumn(['jumlah_mobil_kecil', 'jumlah_mobil_besar']);
        });
    }
};