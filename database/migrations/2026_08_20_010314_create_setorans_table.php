<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setorans', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELASI JUKIR
            |--------------------------------------------------------------------------
            */

            $table->foreignId('jukir_id')
                ->constrained('jukirs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();


            /*
            |--------------------------------------------------------------------------
            | RELASI TITIK PARKIR
            |--------------------------------------------------------------------------
            */

            $table->foreignId('titik_parkir_id')
                ->constrained('titik_parkirs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();


            /*
            |--------------------------------------------------------------------------
            | INFORMASI SETORAN
            |--------------------------------------------------------------------------
            */

            $table->date('tanggal');

            $table->decimal('pendapatan_bruto', 15, 2)
                ->default(0);

            $table->decimal('jumlah_setoran', 15, 2)
                ->default(0);

            $table->decimal('selisih', 15, 2)
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'belum_verifikasi',
                'terverifikasi',
                'ditolak',
            ])->default('belum_verifikasi');


            /*
            |--------------------------------------------------------------------------
            | KETERANGAN
            |--------------------------------------------------------------------------
            */

            $table->text('keterangan')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | INFORMASI VERIFIKASI
            |--------------------------------------------------------------------------
            */

            $table->timestamp('diverifikasi_at')
                ->nullable();

            $table->foreignId('diverifikasi_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index([
                'jukir_id',
                'tanggal',
            ]);

            $table->index([
                'titik_parkir_id',
                'tanggal',
            ]);

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setorans');
    }
};