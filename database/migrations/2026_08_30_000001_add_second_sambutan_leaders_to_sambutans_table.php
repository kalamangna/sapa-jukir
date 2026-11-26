<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sambutans', function (Blueprint $table) {
            if (!Schema::hasColumn('sambutans', 'nama_sekda')) {
                $table->string('nama_sekda')->nullable()->after('jabatan');
            }

            if (!Schema::hasColumn('sambutans', 'jabatan_sekda')) {
                $table->string('jabatan_sekda')->nullable()->after('nama_sekda');
            }

            if (!Schema::hasColumn('sambutans', 'foto_kadis')) {
                $table->string('foto_kadis')->nullable()->after('foto');
            }

            if (!Schema::hasColumn('sambutans', 'foto_sekda')) {
                $table->string('foto_sekda')->nullable()->after('foto_kadis');
            }
        });

        DB::table('sambutans')->whereNull('nama_sekda')->update([
            'nama_sekda' => 'Sekretaris Daerah',
            'jabatan_sekda' => 'Sekretaris Daerah Kabupaten Sinjai',
        ]);
    }

    public function down(): void
    {
        Schema::table('sambutans', function (Blueprint $table) {
            $table->dropColumn(['nama_sekda', 'jabatan_sekda', 'foto_kadis', 'foto_sekda']);
        });
    }
};
