<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_usahas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objek_pendapatan_id')->constrained('objek_pendapatans')->restrictOnDelete();
            $table->string('kode_unit', 50);
            $table->string('nama_unit');
            $table->string('jenis_unit')->nullable();
            $table->string('penyewa_nama')->nullable();
            $table->string('penyewa_identitas')->nullable();
            $table->decimal('luas_m2', 12, 2)->nullable();
            $table->decimal('tarif_sewa', 15, 2)->nullable();
            $table->date('kontrak_mulai')->nullable();
            $table->date('kontrak_selesai')->nullable();
            $table->string('status', 20)->default('kosong');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->unique(['objek_pendapatan_id', 'kode_unit']);
            $table->index(['objek_pendapatan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_usahas');
    }
};