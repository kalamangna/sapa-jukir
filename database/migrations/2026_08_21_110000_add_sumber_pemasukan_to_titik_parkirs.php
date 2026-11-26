<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->foreignId('sumber_pemasukan_id')
                ->nullable()
                ->after('jenis_parkir_id')
                ->constrained('sumber_pemasukans')
                ->nullOnDelete();
        });

        $sources = DB::table('sumber_pemasukans')->pluck('id', 'kode');
        $jenisParkirToSource = DB::table('jenis_parkirs')
            ->pluck('kode', 'id');

        foreach (DB::table('titik_parkirs')->select('id', 'jenis_parkir_id')->get() as $titik) {
            $kode = $jenisParkirToSource[$titik->jenis_parkir_id] ?? null;
            $sourceId = $kode ? ($sources[$kode] ?? null) : null;

            if ($sourceId) {
                DB::table('titik_parkirs')
                    ->where('id', $titik->id)
                    ->update(['sumber_pemasukan_id' => $sourceId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('titik_parkirs', function (Blueprint $table) {
            $table->dropForeign(['sumber_pemasukan_id']);
            $table->dropColumn('sumber_pemasukan_id');
        });
    }
};
