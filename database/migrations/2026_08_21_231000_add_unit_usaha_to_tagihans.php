<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->foreignId('unit_usaha_id')->nullable()->after('objek_pendapatan_id')->constrained('unit_usahas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropForeign(['unit_usaha_id']);
            $table->dropColumn('unit_usaha_id');
        });
    }
};