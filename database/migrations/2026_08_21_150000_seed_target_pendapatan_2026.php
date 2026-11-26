<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const TARGETS = [
        'R-PJTU' => 65000000000,
        'R-TKU' => 3120000000,
        'R-TKP' => 47930000000,
        'R-JASA-USAHA' => 1000000000,
    ];

    public function up(): void
    {
        foreach (self::TARGETS as $kode => $totalSen) {
            $sumberId = DB::table('sumber_pemasukans')->where('kode', $kode)->value('id');

            if (! $sumberId) {
                continue;
            }

            $dasarSen = intdiv($totalSen, 12);
            $sisaSen = $totalSen % 12;

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $targetSen = $dasarSen + ($bulan <= $sisaSen ? 1 : 0);

                DB::table('target_pendapatans')->updateOrInsert(
                    [
                        'sumber_pemasukan_id' => $sumberId,
                        'titik_parkir_id' => null,
                        'objek_pendapatan_id' => null,
                        'tahun' => 2026,
                        'bulan' => $bulan,
                    ],
                    [
                        'target' => $targetSen / 100,
                        'catatan' => 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    public function down(): void
    {
        $sourceIds = DB::table('sumber_pemasukans')
            ->whereIn('kode', array_keys(self::TARGETS))
            ->pluck('id');

        DB::table('target_pendapatans')
            ->whereIn('sumber_pemasukan_id', $sourceIds)
            ->whereNull('titik_parkir_id')
            ->whereNull('objek_pendapatan_id')
            ->where('tahun', 2026)
            ->delete();
    }
};