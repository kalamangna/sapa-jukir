<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karcis_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_pemasukan_id')->constrained()->restrictOnDelete();
            $table->foreignId('jukir_id')->nullable()->constrained()->restrictOnDelete();
            $table->string('penerima', 150);
            $table->string('jenis_karcis', 100);
            $table->string('seri_prefix', 30)->default('');
            $table->unsignedBigInteger('nomor_awal');
            $table->unsignedBigInteger('nomor_akhir');
            $table->unsignedTinyInteger('lebar_nomor')->default(1);
            $table->unsignedBigInteger('nilai_per_karcis');
            $table->date('tanggal_penyerahan');
            $table->timestamps();

            $table->index(['sumber_pemasukan_id', 'seri_prefix', 'nomor_awal', 'nomor_akhir'], 'karcis_allocation_series_idx');
        });

        Schema::create('karcis_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karcis_allocation_id')->constrained()->restrictOnDelete();
            $table->foreignId('setoran_id')->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('nomor_seri');
            $table->unique(['karcis_allocation_id', 'nomor_seri'], 'karcis_usage_unique_series');
            $table->index('setoran_id');
        });

        Schema::table('setorans', function (Blueprint $table) {
            $table->text('karcis_nomor')->nullable()->after('jumlah_mobil_besar');
            $table->unsignedInteger('jumlah_karcis')->nullable()->after('karcis_nomor');
        });
    }

    public function down(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->dropColumn(['karcis_nomor', 'jumlah_karcis']);
        });

        Schema::dropIfExists('karcis_usages');
        Schema::dropIfExists('karcis_allocations');
    }
};
