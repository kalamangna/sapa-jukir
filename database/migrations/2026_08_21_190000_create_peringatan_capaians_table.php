<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peringatan_capaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_pemasukan_id')->nullable()->constrained('sumber_pemasukans')->nullOnDelete();
            $table->foreignId('titik_parkir_id')->nullable()->constrained('titik_parkirs')->nullOnDelete();
            $table->foreignId('objek_pendapatan_id')->nullable()->constrained('objek_pendapatans')->nullOnDelete();
            $table->unsignedSmallInteger('tahun');
            $table->unsignedTinyInteger('bulan');
            $table->string('scope', 30);
            $table->string('judul');
            $table->decimal('target', 15, 2)->default(0);
            $table->decimal('realisasi', 15, 2)->default(0);
            $table->decimal('persentase', 7, 2)->default(0);
            $table->string('status', 20)->default('terbuka');
            $table->text('catatan')->nullable();
            $table->foreignId('ditindaklanjuti_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('ditindaklanjuti_at')->nullable();
            $table->timestamps();
            $table->unique(['scope', 'sumber_pemasukan_id', 'titik_parkir_id', 'objek_pendapatan_id', 'tahun', 'bulan'], 'peringatan_capaian_scope_period_uq');
            $table->index(['status', 'tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peringatan_capaians');
    }
};