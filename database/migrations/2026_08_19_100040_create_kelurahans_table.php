<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->restrictOnDelete();

            $table->string('kode', 20)->unique();
            $table->string('nama');

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->index('nama');
            $table->index('kecamatan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelurahans');
    }
};