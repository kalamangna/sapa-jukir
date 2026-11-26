<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemanfaatan_asets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_aset_id')->constrained('area_asets')->restrictOnDelete();
            $table->string('pihak_pemanfaat');
            $table->string('jenis_kegiatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('tarif_sewa', 15, 2)->nullable();
            $table->decimal('nilai_sewa', 15, 2);
            $table->string('status', 20)->default('direncanakan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->index(['area_aset_id', 'status']);
            $table->index(['tanggal_mulai', 'tanggal_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemanfaatan_asets');
    }
};