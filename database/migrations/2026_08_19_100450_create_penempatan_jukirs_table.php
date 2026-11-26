<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penempatan_jukirs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jukir_id')
                ->constrained('jukirs')
                ->cascadeOnDelete();

            $table->foreignId('titik_parkir_id')
                ->constrained('titik_parkirs')
                ->cascadeOnDelete();

            $table->date('tanggal_mulai');

            $table->date('tanggal_selesai')->nullable();

            $table->enum('status', [
                'aktif',
                'selesai',
                'dibatalkan',
            ])->default('aktif');

            $table->string('surat_penugasan')->nullable();

            $table->text('keterangan')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatan_jukirs');
    }
};