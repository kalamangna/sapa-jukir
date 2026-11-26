<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_pendapatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_pemasukan_id')
                ->constrained('sumber_pemasukans')
                ->restrictOnDelete();
            $table->foreignId('titik_parkir_id')
                ->nullable()
                ->constrained('titik_parkirs')
                ->nullOnDelete();
            $table->unsignedSmallInteger('tahun');
            $table->unsignedTinyInteger('bulan');
            $table->decimal('target', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index([
                'sumber_pemasukan_id',
                'titik_parkir_id',
                'tahun',
                'bulan',
            ], 'target_pendapatan_scope_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_pendapatans');
    }
};