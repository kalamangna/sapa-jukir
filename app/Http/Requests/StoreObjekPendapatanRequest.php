<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreObjekPendapatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sumber_pemasukan_id' => ['required', 'integer', Rule::exists('sumber_pemasukans', 'id')->where('status', true)],
            'kode' => ['required', 'string', 'max:50'],
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:tempat_usaha,aset_daerah,parkir_khusus'],
            'alamat' => ['nullable', 'string'],
            'nama_pengelola' => ['nullable', 'string', 'max:255'],
            'nomor_identitas' => ['nullable', 'string', 'max:255'],
            'jenis_usaha' => ['nullable', 'string', 'max:255'],
            'jenis_aset' => ['nullable', 'string', 'max:255'],
            'nomor_aset' => ['nullable', 'string', 'max:255'],
            'luas_m2' => ['nullable', 'numeric', 'min:0'],
            'tarif_sewa' => ['nullable', 'numeric', 'min:0'],
            'nomor_kontrak' => ['nullable', 'string', 'max:100'],
            'kontrak_mulai' => ['nullable', 'date'],
            'kontrak_selesai' => ['nullable', 'date', 'after_or_equal:kontrak_mulai'],
            'potensi_harian' => ['nullable', 'numeric', 'min:0'],
            'potensi_bulanan' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:aktif,nonaktif,bermasalah'],
            'metadata' => ['nullable', 'array'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            if (in_array($this->input('tipe'), ['tempat_usaha', 'aset_daerah'], true)
                && ! $this->filled('tarif_sewa')) {
                $validator->errors()->add('tarif_sewa', 'Tarif sewa wajib diisi untuk tempat usaha atau aset daerah.');
            }
        }];
    }
}