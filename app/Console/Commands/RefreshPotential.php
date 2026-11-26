<?php

namespace App\Console\Commands;

use App\Services\PotentialCalculationService;
use Illuminate\Console\Command;

class RefreshPotential extends Command
{
    protected $signature = 'potensi:refresh';
    protected $description = 'Hitung ulang potensi usaha dan parkir dari parameter aktif';

    public function handle(PotentialCalculationService $service): int
    {
        $result = $service->refresh();
        $this->info("Potensi diperbarui: {$result['updatedObjects']} objek usaha, {$result['updatedPoints']} titik parkir.");

        return self::SUCCESS;
    }
}