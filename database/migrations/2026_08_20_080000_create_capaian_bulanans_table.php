<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capaian_bulanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tahun');
            $table->unsignedTinyInteger('bulan');
            $table->decimal('target', 15, 2)->default(0);
            $table->decimal('realisasi', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capaian_bulanans');
    }
};
