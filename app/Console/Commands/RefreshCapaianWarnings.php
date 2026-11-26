<?php

namespace App\Console\Commands;

use App\Models\ObjekPendapatan;
use App\Models\PeringatanCapaian;
use App\Models\Setoran;
use App\Models\SumberPemasukan;
use App\Models\TargetPendapatan;
use App\Models\TitikParkir;
use Illuminate\Console\Command;

class RefreshCapaianWarnings extends Command
{
    protected $signature = 'capaian:refresh-warnings {--tahun= : Tahun capaian} {--bulan= : Bulan capaian}';

    protected $description = 'Sinkronkan peringatan capaian dari realisasi setoran terverifikasi';

    public function handle(): int
    {
        $tahun = (int) ($this->option('tahun') ?: now()->year);
        $bulan = (int) ($this->option('bulan') ?: now()->month);

        $targets = TargetPendapatan::query()
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get();

        $realisasi = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        $this->syncSources($targets, $realisasi, $tahun, $bulan);
        $this->syncLocations($targets, $realisasi, $tahun, $bulan);
        $this->syncObjects($targets, $realisasi, $tahun, $bulan);

        $this->info("Peringatan capaian {$bulan}/{$tahun} berhasil disinkronkan.");

        return self::SUCCESS;
    }

    private function syncSources($targets, $realisasi, int $tahun, int $bulan): void
    {
        $targetBySource = $targets->groupBy('sumber_pemasukan_id')->map(function ($items) {
            $scoped = $items->contains(fn ($item) => $item->titik_parkir_id !== null || $item->objek_pendapatan_id !== null);

            return (float) $items->filter(fn ($item) => $scoped
                ? $item->titik_parkir_id !== null || $item->objek_pendapatan_id !== null
                : $item->titik_parkir_id === null && $item->objek_pendapatan_id === null)->sum('target');
        });
        $realBySource = (clone $realisasi)->selectRaw('sumber_pemasukan_id, SUM(jumlah_setoran) AS total')->groupBy('sumber_pemasukan_id')->pluck('total', 'sumber_pemasukan_id');

        SumberPemasukan::where('status', true)->get()->each(function ($source) use ($targetBySource, $realBySource, $tahun, $bulan) {
            $target = (float) $targetBySource->get($source->id, 0);
            $real = (float) $realBySource->get($source->id, 0);
            $this->upsertWarning('sumber', $source->id, null, null, $source->nama, $target, $real, $tahun, $bulan);
        });
    }

    private function syncLocations($targets, $realisasi, int $tahun, int $bulan): void
    {
        $targetByLocation = $targets->filter(fn ($target) => $target->titik_parkir_id !== null)->groupBy('titik_parkir_id')->map(fn ($items) => (float) $items->sum('target'));
        $realByLocation = (clone $realisasi)->whereNotNull('titik_parkir_id')->selectRaw('titik_parkir_id, SUM(jumlah_setoran) AS total')->groupBy('titik_parkir_id')->pluck('total', 'titik_parkir_id');

        TitikParkir::whereIn('id', $targetByLocation->keys())->get()->each(function ($location) use ($targetByLocation, $realByLocation, $tahun, $bulan) {
            $target = (float) $targetByLocation->get($location->id, 0);
            $real = (float) $realByLocation->get($location->id, 0);
            $this->upsertWarning('lokasi', null, $location->id, null, $location->nama, $target, $real, $tahun, $bulan);
        });
    }

    private function syncObjects($targets, $realisasi, int $tahun, int $bulan): void
    {
        $targetByObject = $targets->filter(fn ($target) => $target->objek_pendapatan_id !== null)->groupBy('objek_pendapatan_id')->map(fn ($items) => (float) $items->sum('target'));
        $realByObject = (clone $realisasi)->whereNotNull('objek_pendapatan_id')->selectRaw('objek_pendapatan_id, SUM(jumlah_setoran) AS total')->groupBy('objek_pendapatan_id')->pluck('total', 'objek_pendapatan_id');

        ObjekPendapatan::whereIn('id', $targetByObject->keys())->get()->each(function ($object) use ($targetByObject, $realByObject, $tahun, $bulan) {
            $target = (float) $targetByObject->get($object->id, 0);
            $real = (float) $realByObject->get($object->id, 0);
            $this->upsertWarning('objek', null, null, $object->id, $object->nama, $target, $real, $tahun, $bulan);
        });
    }

    private function upsertWarning(string $scope, ?int $sourceId, ?int $locationId, ?int $objectId, string $title, float $target, float $real, int $tahun, int $bulan): void
    {
        $percentage = $target > 0 ? min(100, ($real / $target) * 100) : 0;
        if ($percentage >= 80) {
            return;
        }

        PeringatanCapaian::updateOrCreate(
            ['scope' => $scope, 'sumber_pemasukan_id' => $sourceId, 'titik_parkir_id' => $locationId, 'objek_pendapatan_id' => $objectId, 'tahun' => $tahun, 'bulan' => $bulan],
            ['judul' => $title, 'target' => $target, 'realisasi' => $real, 'persentase' => $percentage]
        );
    }
}