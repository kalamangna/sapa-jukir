<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_daerahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset', 80)->unique();
            $table->string('nama_aset');
            $table->string('jenis_aset')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('nomor_register')->nullable()->unique();
            $table->decimal('luas_total_m2', 15, 2)->nullable();
            $table->string('status', 20)->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('area_asets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_daerah_id')->constrained('aset_daerahs')->restrictOnDelete();
            $table->string('kode_area', 80);
            $table->string('nama_area');
            $table->decimal('luas_m2', 15, 2)->nullable();
            $table->decimal('tarif_sewa', 15, 2)->nullable();
            $table->string('status', 20)->default('tersedia');
            $table->string('pemanfaat_terakhir')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->unique(['aset_daerah_id', 'kode_area']);
            $table->index(['aset_daerah_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('area_asets');
        Schema::dropIfExists('aset_daerahs');
    }
};