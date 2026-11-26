<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_parkir_id')
                ->constrained('jenis_parkirs')
                ->restrictOnDelete();

            $table->string('jenis_kendaraan', 50);

            $table->decimal('nominal', 15, 2);

            $table->date('berlaku_mulai');
            $table->date('berlaku_sampai')->nullable();

            $table->boolean('status')->default(true);

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index([
                'jenis_parkir_id',
                'jenis_kendaraan',
            ]);

            $table->index([
                'berlaku_mulai',
                'berlaku_sampai',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifs');
    }
};