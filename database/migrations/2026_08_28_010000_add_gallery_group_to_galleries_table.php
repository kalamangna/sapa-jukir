<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->uuid('gallery_group')->nullable()->after('tanggal_kegiatan');
            $table->index('gallery_group');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['gallery_group']);
            $table->dropColumn('gallery_group');
        });
    }
};