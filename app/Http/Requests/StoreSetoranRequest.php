<?php

namespace App\Http\Requests;

use App\Models\SumberPemasukan;
use App\Models\PenempatanJukir;
use App\Models\TitikParkir;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreSetoranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $sumber = SumberPemasukan::find($this->integer('sumber_pemasukan_id'));

        if (! in_array($sumber?->kode, ['R-TKP', 'R-PJTU'], true)) {
            $this->merge([
                'jumlah_motor' => null,
                'jumlah_mobil' => null,
                'jumlah_mobil_kecil' => null,
                'jumlah_mobil_besar' => null,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'sumber_pemasukan_id' => [
                'required',
                'integer',
                Rule::exists('sumber_pemasukans', 'id')->where('status', true),
            ],
            'objek_pendapatan_id' => ['nullable', 'integer', 'exists:objek_pendapatans,id'],
            'jukir_id' => ['nullable', 'integer', 'exists:jukirs,id'],
            'titik_parkir_id' => ['nullable', 'integer', 'exists:titik_parkirs,id'],
            'tanggal' => ['required', 'date'],
            'karcis_lines' => ['required', 'array', 'min:1', 'max:10'],
            'karcis_lines.*.allocation_id' => ['required', 'integer', 'exists:karcis_allocations,id'],
            'karcis_lines.*.nomor' => ['required', 'string', 'max:20000'],
            'jumlah_motor' => ['nullable', 'integer', 'min:0'],
            'jumlah_mobil' => ['nullable', 'integer', 'min:0'],
            'jumlah_mobil_kecil' => ['nullable', 'integer', 'min:0'],
            'jumlah_mobil_besar' => ['nullable', 'integer', 'min:0'],
            'pendapatan_bruto' => ['required', 'numeric', 'min:0'],
            'jumlah_setoran' => ['required', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function after(): array
    {
        return [$this->validateParkirContext(...)];
    }

    private function validateParkirContext(Validator $validator): void
    {
        $sumber = SumberPemasukan::find($this->integer('sumber_pemasukan_id'));
        $isNonOperational = in_array($sumber?->kode, ['R-TKU', 'R-JASA-USAHA', 'R-SPATKT'], true);
        $jukirId = $this->integer('jukir_id');
        $titikParkirId = $this->integer('titik_parkir_id');

        if (! $isNonOperational && (! $this->filled('jukir_id') || ! $this->filled('titik_parkir_id'))) {
            $validator->errors()->add(
                'titik_parkir_id',
                'Jukir dan titik parkir wajib diisi untuk sumber pemasukan parkir.'
            );
        }

        $titik = $titikParkirId ? TitikParkir::find($titikParkirId) : null;
        if ($titik && (int) $titik->sumber_pemasukan_id !== $this->integer('sumber_pemasukan_id')) {
            $validator->errors()->add(
                'titik_parkir_id',
                'Titik parkir harus menggunakan sumber pendapatan yang sama dengan setoran.'
            );
        }

        $objek = $this->integer('objek_pendapatan_id');
        if ($objek) {
            $objekSourceId = \App\Models\ObjekPendapatan::whereKey($objek)->value('sumber_pemasukan_id');
            if ((int) $objekSourceId !== $this->integer('sumber_pemasukan_id')) {
                $validator->errors()->add('objek_pendapatan_id', 'Objek pendapatan harus menggunakan sumber yang sama dengan setoran.');
            }
        }

        if ($isNonOperational || ! $jukirId || ! $titikParkirId || ! $this->filled('tanggal')) {
            return;
        }

        $tanggal = $this->date('tanggal');
        $penempatanAktif = PenempatanJukir::query()
            ->where('jukir_id', $jukirId)
            ->where('titik_parkir_id', $titikParkirId)
            ->where('status', 'aktif')
            ->whereDate('tanggal_mulai', '<=', $tanggal->toDateString())
            ->where(function ($query) use ($tanggal) {
                $query->whereNull('tanggal_selesai')
                    ->orWhereDate('tanggal_selesai', '>=', $tanggal->toDateString());
            })
            ->exists();

        if (! $penempatanAktif) {
            $validator->errors()->add(
                'jukir_id',
                'Jukir tidak memiliki penempatan aktif pada titik dan tanggal setoran.'
            );
        }
    }
}