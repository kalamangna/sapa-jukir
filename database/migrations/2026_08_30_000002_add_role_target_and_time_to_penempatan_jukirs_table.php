<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penempatan_jukirs', function (Blueprint $table) {
            if (! Schema::hasColumn('penempatan_jukirs', 'role')) {
                $table->string('role', 20)->default('anggota')->after('titik_parkir_id');
            }

            if (! Schema::hasColumn('penempatan_jukirs', 'target_per_hari')) {
                $table->decimal('target_per_hari', 15, 2)->nullable()->after('role');
            }

            if (! Schema::hasColumn('penempatan_jukirs', 'waktu_kerja')) {
                $table->string('waktu_kerja')->nullable()->after('target_per_hari');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penempatan_jukirs', function (Blueprint $table) {
            if (Schema::hasColumn('penempatan_jukirs', 'waktu_kerja')) {
                $table->dropColumn('waktu_kerja');
            }

            if (Schema::hasColumn('penempatan_jukirs', 'target_per_hari')) {
                $table->dropColumn('target_per_hari');
            }

            if (Schema::hasColumn('penempatan_jukirs', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
