<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jukirs', function (Blueprint $table) {
            $table->id();

            $table->string('kode_jukir', 30)->unique();

            $table->foreignId('jenis_jukir_id')
                ->constrained('jenis_jukirs')
                ->restrictOnDelete();

            $table->string('nik', 16)->unique();

            $table->string('nama');

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->enum('jenis_kelamin', [
                'L',
                'P',
            ])->nullable();

            $table->text('alamat')->nullable();

            $table->foreignId('kecamatan_id')
                ->nullable()
                ->constrained('kecamatans')
                ->nullOnDelete();

            $table->foreignId('kelurahan_id')
                ->nullable()
                ->constrained('kelurahans')
                ->nullOnDelete();

            $table->string('no_hp')->nullable();

            $table->string('foto')->nullable();
            $table->string('foto_ktp')->nullable();

            $table->string('nomor_kartu')->nullable();

            $table->date('tanggal_terdaftar')->nullable();
            $table->date('tanggal_berakhir')->nullable();

            $table->enum('status', [
                'aktif',
                'nonaktif',
                'ditangguhkan',
                'berhenti',
            ])->default('aktif');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index('nama');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jukirs');
    }
};