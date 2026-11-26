<?php

namespace App\Services;

use App\Models\ObjekPendapatan;
use App\Models\Tarif;
use App\Models\TitikParkir;
use App\Models\UnitUsaha;
use Illuminate\Support\Facades\DB;

class PotentialCalculationService
{
    public function refresh(): array
    {
        return DB::transaction(function () {
            $updatedObjects = $this->refreshBusinessObjects();
            $updatedPoints = $this->refreshParkingPoints();

            return compact('updatedObjects', 'updatedPoints');
        });
    }

    private function refreshBusinessObjects(): int
    {
        $updated = 0;
        ObjekPendapatan::where('tipe', 'tempat_usaha')->each(function (ObjekPendapatan $object) use (&$updated) {
            $monthly = (float) UnitUsaha::where('objek_pendapatan_id', $object->id)
                ->where('status', 'aktif')
                ->sum('tarif_sewa');
            if ($monthly <= 0) return;

            $object->update(['potensi_bulanan' => $monthly, 'potensi_harian' => $monthly / 30]);
            $updated++;
        });

        return $updated;
    }

    private function refreshParkingPoints(): int
    {
        $updated = 0;
        TitikParkir::with('jenisParkir')->where('status', 'aktif')->each(function (TitikParkir $point) use (&$updated) {
            if (! $point->jenis_parkir_id) return;

            $tariffs = Tarif::where('jenis_parkir_id', $point->jenis_parkir_id)
                ->where('status', true)
                ->whereDate('berlaku_mulai', '<=', today())
                ->where(function ($query) {
                    $query->whereNull('berlaku_sampai')->orWhereDate('berlaku_sampai', '>=', today());
                })
                ->get()
                ->keyBy(fn (Tarif $tarif) => strtolower($tarif->jenis_kendaraan));

            $mobilKecil = $point->kapasitas_mobil_kecil ?? $point->kapasitas_mobil ?? 0;
            $daily = ((int) $point->kapasitas_motor * (float) ($tariffs->get('motor')?->nominal ?? 0))
                + ((int) $mobilKecil * (float) ($tariffs->get('mobil_kecil')?->nominal ?? 0))
                + ((int) ($point->kapasitas_mobil_besar ?? 0) * (float) ($tariffs->get('mobil_besar')?->nominal ?? 0));
            if ($daily <= 0) return;

            $point->update(['potensi_harian' => $daily, 'potensi_bulanan' => $daily * 30]);
            $updated++;
        });

        return $updated;
    }
}