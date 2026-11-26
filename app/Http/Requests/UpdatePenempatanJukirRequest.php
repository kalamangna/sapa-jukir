<?php

namespace App\Http\Requests;

use App\Models\PenempatanJukir;

class UpdatePenempatanJukirRequest extends StorePenempatanJukirRequest
{
    protected function validateActiveOverlap(\Illuminate\Validation\Validator $validator): void
    {
        if ($this->input('status') !== 'aktif') {
            return;
        }

        $start = $this->date('tanggal_mulai');
        $end = $this->date('tanggal_selesai');

        if (! $start) {
            return;
        }

        $existing = $this->route('penempatan_jukir')
            ?? $this->route('penempatanJukir');
        $existingId = $existing?->id;

        $sameJukirOverlap = PenempatanJukir::query()
            ->whereKeyNot($existingId)
            ->where('status', 'aktif')
            ->where('jukir_id', $this->integer('jukir_id'))
            ->whereDate('tanggal_mulai', '<=', $end?->toDateString() ?? '9999-12-31')
            ->where(function ($query) use ($start) {
                $query->whereNull('tanggal_selesai')
                    ->orWhereDate('tanggal_selesai', '>=', $start->toDateString());
            })
            ->exists();

        if ($sameJukirOverlap) {
            $validator->errors()->add(
                'jukir_id',
                'Petugas ini sudah aktif pada periode yang sama di penugasan lain.'
            );
        }

        if ($this->input('role') === 'koordinator') {
            // Get the target location
            $titikParkir = \App\Models\TitikParkir::find($this->integer('titik_parkir_id'));
            $maxKoordinator = $titikParkir ? $titikParkir->jumlah_koordinator : 1;

            // Count active coordinators for this location during the same period (excluding current record)
            $activeCoordinators = PenempatanJukir::query()
                ->whereKeyNot($existingId)
                ->where('status', 'aktif')
                ->where('titik_parkir_id', $this->integer('titik_parkir_id'))
                ->where('role', 'koordinator')
                ->whereDate('tanggal_mulai', '<=', $end?->toDateString() ?? '9999-12-31')
                ->where(function ($query) use ($start) {
                    $query->whereNull('tanggal_selesai')
                        ->orWhereDate('tanggal_selesai', '>=', $start->toDateString());
                })
                ->count();

            if ($activeCoordinators >= $maxKoordinator) {
                $validator->errors()->add(
                    'role',
                    "Sudah ada {$activeCoordinators} koordinator aktif untuk titik parkir ini pada periode tersebut (max: {$maxKoordinator})."
                );
            }
        }
    }
}