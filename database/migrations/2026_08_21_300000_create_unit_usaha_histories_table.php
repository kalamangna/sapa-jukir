<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_usaha_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_usaha_id')->constrained('unit_usahas')->cascadeOnDelete();
            $table->foreignId('diubah_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->string('aksi', 30);
            $table->json('nilai_lama')->nullable();
            $table->json('nilai_baru')->nullable();
            $table->timestamps();
            $table->index(['unit_usaha_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_usaha_histories');
    }
};