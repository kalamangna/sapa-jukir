<?php

namespace App\Http\Requests;

use App\Models\TitikParkir;
use App\Models\ObjekPendapatan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreTargetPendapatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sumber_pemasukan_id' => [
                'required',
                'integer',
                Rule::exists('sumber_pemasukans', 'id')->where('status', true),
            ],
            'titik_parkir_id' => ['nullable', 'integer', 'exists:titik_parkirs,id'],
            'objek_pendapatan_id' => ['nullable', 'integer', 'exists:objek_pendapatans,id'],
            'tahun' => ['required', 'integer', 'min:2026', 'max:2100'],
            'bulan' => ['required', 'integer', 'between:1,12'],
            'target' => ['required', 'numeric', 'min:0'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function after(): array
    {
        return [$this->validateLocationSource(...)];
    }

    protected function validateLocationSource(Validator $validator): void
    {
        if ($this->filled('titik_parkir_id') && $this->filled('objek_pendapatan_id')) {
            $validator->errors()->add('objek_pendapatan_id', 'Target harus memakai titik parkir atau objek pendapatan, bukan keduanya.');
        }

        if (! $this->filled('titik_parkir_id')) {
            $this->validateObjectSource($validator);
            return;
        }

        $this->validateObjectSource($validator);
    }

    private function validateObjectSource(Validator $validator): void
    {

        $titik = TitikParkir::find($this->integer('titik_parkir_id'));
        if ($titik && (int) $titik->sumber_pemasukan_id !== $this->integer('sumber_pemasukan_id')) {
            $validator->errors()->add(
                'titik_parkir_id',
                'Lokasi harus menggunakan sumber pendapatan yang sama dengan target.'
            );
        }

        $objek = $this->filled('objek_pendapatan_id')
            ? ObjekPendapatan::find($this->integer('objek_pendapatan_id'))
            : null;
        if ($objek && (int) $objek->sumber_pemasukan_id !== $this->integer('sumber_pemasukan_id')) {
            $validator->errors()->add('objek_pendapatan_id', 'Objek pendapatan harus menggunakan sumber yang sama dengan target.');
        }
    }
}