<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('titik_parkirs', function (Blueprint $table) {
            $table->id();

            $table->string('kode_titik', 30)->unique();

            $table->string('nama');
            $table->text('alamat');

            $table->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->restrictOnDelete();

            $table->foreignId('kelurahan_id')
                ->constrained('kelurahans')
                ->restrictOnDelete();

            $table->foreignId('jenis_parkir_id')
                ->constrained('jenis_parkirs')
                ->restrictOnDelete();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->enum('status', [
                'aktif',
                'nonaktif',
                'sementara',
                'bermasalah',
            ])->default('aktif');

            $table->unsignedInteger('kapasitas_motor')->nullable();
            $table->unsignedInteger('kapasitas_mobil')->nullable();

            $table->decimal('potensi_harian', 15, 2)->nullable();
            $table->decimal('potensi_bulanan', 15, 2)->nullable();

            $table->string('foto')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index('nama');
            $table->index('status');
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('titik_parkirs');
    }
};