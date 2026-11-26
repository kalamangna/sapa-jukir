<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objek_pendapatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_pemasukan_id')
                ->constrained('sumber_pemasukans')
                ->restrictOnDelete();
            $table->string('kode', 50);
            $table->string('nama');
            $table->string('tipe', 30);
            $table->text('alamat')->nullable();
            $table->string('nama_pengelola')->nullable();
            $table->string('nomor_identitas')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->string('jenis_aset')->nullable();
            $table->string('nomor_aset')->nullable();
            $table->decimal('potensi_harian', 15, 2)->nullable();
            $table->decimal('potensi_bulanan', 15, 2)->nullable();
            $table->string('status', 20)->default('aktif');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['sumber_pemasukan_id', 'kode'], 'objek_pendapatan_source_code_uq');
            $table->index(['sumber_pemasukan_id', 'tipe'], 'objek_pendapatan_source_type_idx');
            $table->index('status');
        });

        Schema::table('setorans', function (Blueprint $table) {
            $table->foreignId('objek_pendapatan_id')
                ->nullable()
                ->after('sumber_pemasukan_id')
                ->constrained('objek_pendapatans')
                ->restrictOnDelete();
        });

        Schema::table('target_pendapatans', function (Blueprint $table) {
            $table->foreignId('objek_pendapatan_id')
                ->nullable()
                ->after('sumber_pemasukan_id')
                ->constrained('objek_pendapatans')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('target_pendapatans', function (Blueprint $table) {
            $table->dropForeign(['objek_pendapatan_id']);
            $table->dropColumn('objek_pendapatan_id');
        });

        Schema::table('setorans', function (Blueprint $table) {
            $table->dropForeign(['objek_pendapatan_id']);
            $table->dropColumn('objek_pendapatan_id');
        });

        Schema::dropIfExists('objek_pendapatans');
    }
};