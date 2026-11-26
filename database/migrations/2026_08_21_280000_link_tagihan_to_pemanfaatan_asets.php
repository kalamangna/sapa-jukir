<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemanfaatan_asets', function (Blueprint $table) {
            $table->foreignId('tagihan_id')->nullable()->after('area_aset_id')->constrained('tagihans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pemanfaatan_asets', function (Blueprint $table) {
            $table->dropForeign(['tagihan_id']);
            $table->dropColumn('tagihan_id');
        });
    }
};