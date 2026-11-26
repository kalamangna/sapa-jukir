<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_pemasukan_id')->constrained('sumber_pemasukans')->restrictOnDelete();
            $table->foreignId('objek_pendapatan_id')->nullable()->constrained('objek_pendapatans')->restrictOnDelete();
            $table->string('nomor_tagihan', 80)->unique();
            $table->string('pihak_tertagih')->nullable();
            $table->string('uraian');
            $table->date('tanggal_terbit');
            $table->date('tanggal_jatuh_tempo');
            $table->decimal('nilai_tagihan', 15, 2);
            $table->string('status', 20)->default('terbit');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index(['sumber_pemasukan_id', 'status', 'tanggal_jatuh_tempo']);
        });

        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihans')->cascadeOnDelete();
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('metode', 30)->nullable();
            $table->string('referensi', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index(['tagihan_id', 'tanggal_bayar']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
        Schema::dropIfExists('tagihans');
    }
};