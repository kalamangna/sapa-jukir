<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_motor')->nullable()->after('tanggal');
            $table->unsignedInteger('jumlah_mobil')->nullable()->after('jumlah_motor');
        });
    }

    public function down(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->dropColumn(['jumlah_motor', 'jumlah_mobil']);
        });
    }
};