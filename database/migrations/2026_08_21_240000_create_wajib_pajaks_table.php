<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wajib_pajaks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('npwp', 32)->nullable()->unique();
            $table->string('nik', 32)->nullable()->unique();
            $table->string('alamat')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('status', 20)->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index('status');
        });

        Schema::table('objek_pendapatans', function (Blueprint $table) {
            $table->foreignId('wajib_pajak_id')->nullable()->after('sumber_pemasukan_id')->constrained('wajib_pajaks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('objek_pendapatans', function (Blueprint $table) {
            $table->dropForeign(['wajib_pajak_id']);
            $table->dropColumn('wajib_pajak_id');
        });
        Schema::dropIfExists('wajib_pajaks');
    }
};