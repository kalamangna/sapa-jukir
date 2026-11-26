<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->foreignId('jukir_id')->nullable()->change();
            $table->foreignId('titik_parkir_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->foreignId('jukir_id')->nullable(false)->change();
            $table->foreignId('titik_parkir_id')->nullable(false)->change();
        });
    }
};