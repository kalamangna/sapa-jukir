<?php

namespace App\Http\Requests;

use App\Models\PenempatanJukir;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePenempatanJukirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jukir_id' => ['required', 'integer', 'exists:jukirs,id'],
            'titik_parkir_id' => ['required', 'integer', 'exists:titik_parkirs,id'],
            'role' => ['required', 'in:koordinator,anggota'],
            'target_per_hari' => ['nullable', 'numeric', 'min:0'],
            'waktu_kerja' => ['nullable', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', 'in:aktif,selesai,dibatalkan'],
            'surat_penugasan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function after(): array
    {
        return [$this->validateActiveOverlap(...)];
    }

    protected function validateActiveOverlap(Validator $validator): void
    {
        if ($this->input('status') !== 'aktif') {
            return;
        }

        $start = $this->date('tanggal_mulai');
        $end = $this->date('tanggal_selesai');

        if (! $start) {
            return;
        }

        $sameJukirOverlap = PenempatanJukir::query()
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

            // Count active coordinators for this location during the same period
            $activeCoordinators = PenempatanJukir::query()
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