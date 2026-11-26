<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $sourceId = DB::table('sumber_pemasukans')
            ->where('kode', 'R-TKU')
            ->value('id');

        if (! $sourceId) {
            return;
        }

        DB::table('titik_parkirs')
            ->where('kode_titik', 'R.Kios-01')
            ->update([
                'sumber_pemasukan_id' => $sourceId,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        $sourceId = DB::table('sumber_pemasukans')
            ->where('kode', 'R-SPATKT')
            ->value('id');

        if (! $sourceId) {
            return;
        }

        DB::table('titik_parkirs')
            ->where('kode_titik', 'R.Kios-01')
            ->update([
                'sumber_pemasukan_id' => $sourceId,
                'updated_at' => now(),
            ]);
    }
};
