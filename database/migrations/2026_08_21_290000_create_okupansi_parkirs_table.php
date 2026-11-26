<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('okupansi_parkirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('titik_parkir_id')->constrained('titik_parkirs')->restrictOnDelete();
            $table->date('tanggal');
            $table->unsignedInteger('jumlah_motor')->default(0);
            $table->unsignedInteger('jumlah_mobil')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['titik_parkir_id', 'tanggal']);
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('okupansi_parkirs');
    }
};