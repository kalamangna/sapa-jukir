<?php

namespace App\Http\Requests;

use App\Models\Kelurahan;
use App\Models\SumberPemasukan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreTitikParkirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $sourceId = $this->input('sumber_pemasukan_id');
        $source = $sourceId ? SumberPemasukan::find($sourceId) : null;
        $isBusinessSource = $source && in_array($source->kode, ['R-TKU', 'R-JASA-USAHA', 'R-SPATKT'], true);

        if ($isBusinessSource) {
            $this->merge([
                'jenis_parkir_id' => null,
                'kapasitas_motor' => null,
                'kapasitas_mobil' => null,
                'kapasitas_mobil_kecil' => null,
                'kapasitas_mobil_besar' => null,
                'kapasitas_total' => null,
                'potensi_harian' => null,
                'potensi_bulanan' => null,
            ]);
        }

        if ($source && ! $isBusinessSource) {
            $this->merge([
                'jumlah_unit' => null,
                'luas_m2' => null,
            ]);
        }

        if (! $this->filled('jumlah_koordinator')) {
            $this->merge(['jumlah_koordinator' => 1]);
        }
    }

    public function rules(): array
    {
        return [
            'kode_titik' => ['required', 'string', 'max:50', 'unique:titik_parkirs,kode_titik'],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'kecamatan_id' => ['required', 'integer', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'integer', 'exists:kelurahans,id'],
            'jenis_parkir_id' => ['nullable', 'integer', 'exists:jenis_parkirs,id'],
            'sumber_pemasukan_id' => [
                'required',
                'integer',
                Rule::exists('sumber_pemasukans', 'id')->where('status', true),
            ],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:aktif,nonaktif,sementara,bermasalah'],
            'kapasitas_motor' => ['nullable', 'integer', 'min:0'],
            'kapasitas_mobil' => ['nullable', 'integer', 'min:0'],
            'kapasitas_mobil_kecil' => ['nullable', 'integer', 'min:0'],
            'kapasitas_mobil_besar' => ['nullable', 'integer', 'min:0'],
            'kapasitas_total' => ['nullable', 'integer', 'min:0'],
            'jumlah_unit' => ['nullable', 'integer', 'min:0'],
            'luas_m2' => ['nullable', 'numeric', 'min:0'],
            'nama_pengelola' => ['nullable', 'string', 'max:255'],
            'telepon_pengelola' => ['nullable', 'string', 'max:30'],
            'potensi_harian' => ['nullable', 'numeric', 'min:0'],
            'potensi_bulanan' => ['nullable', 'numeric', 'min:0'],
            'jumlah_koordinator' => ['required', 'integer', 'in:1,2'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function after(): array
    {
        return [$this->validateBusinessRules(...)];
    }

    protected function validateBusinessRules(Validator $validator): void
    {
        $sumber = SumberPemasukan::find($this->integer('sumber_pemasukan_id'));

        if ($sumber && ! in_array($sumber->kode, ['R-JASA-USAHA', 'R-SPATKT', 'R-TKU'], true) && ! $this->filled('jenis_parkir_id')) {
            $validator->errors()->add('jenis_parkir_id', 'Jenis parkir wajib dipilih untuk sumber pemasukan parkir.');
        }

        $kelurahan = Kelurahan::find($this->integer('kelurahan_id'));
        if ($kelurahan && (int) $kelurahan->kecamatan_id !== $this->integer('kecamatan_id')) {
            $validator->errors()->add('kelurahan_id', 'Kelurahan harus berada di kecamatan yang dipilih.');
        }

        if ($sumber?->kode === 'R-TKP') {
            if (! $this->filled('kapasitas_total')) {
                $validator->errors()->add('kapasitas_total', 'Kapasitas total wajib diisi untuk parkir khusus.');
            }
            if (! $this->filled('nama_pengelola')) {
                $validator->errors()->add('nama_pengelola', 'Nama penanggung jawab wajib diisi untuk parkir khusus.');
            }
        }

        $kapasitasMotor = (int) $this->input('kapasitas_motor', 0);
        $kapasitasMobilKecil = (int) ($this->input('kapasitas_mobil_kecil') ?? $this->input('kapasitas_mobil', 0));
        $kapasitasMobilBesar = (int) $this->input('kapasitas_mobil_besar', 0);
        if ($this->filled('kapasitas_total') && (int) $this->input('kapasitas_total') < $kapasitasMotor + $kapasitasMobilKecil + $kapasitasMobilBesar) {
            $validator->errors()->add('kapasitas_total', 'Kapasitas total tidak boleh lebih kecil dari kapasitas motor dan mobil.');
        }
    }
}