<?php

namespace App\Http\Requests;

use App\Models\Kelurahan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreJukirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | JENIS JUKIR
            |--------------------------------------------------------------------------
            */

            'jenis_jukir_id' => [
                'required',
                'integer',
                Rule::exists('jenis_jukirs', 'id'),
            ],


            /*
            |--------------------------------------------------------------------------
            | IDENTITAS
            |--------------------------------------------------------------------------
            */

            'nik' => [
                'required',
                'string',
                'digits:16',
                Rule::unique('jukirs', 'nik'),
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
                'before:today',
            ],

            'jenis_kelamin' => [
                'nullable',
                Rule::in(['L', 'P']),
            ],


            /*
            |--------------------------------------------------------------------------
            | ALAMAT
            |--------------------------------------------------------------------------
            */

            'alamat' => [
                'nullable',
                'string',
            ],

            'kecamatan_id' => [
                'nullable',
                'integer',
                Rule::exists('kecamatans', 'id'),
            ],

            'kelurahan_id' => [
                'nullable',
                'integer',
                Rule::exists('kelurahans', 'id'),
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],


            /*
            |--------------------------------------------------------------------------
            | DOKUMEN
            |--------------------------------------------------------------------------
            */

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'foto_ktp' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'dokumen_pendukung' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,pdf',
                'max:5120',
            ],

            'nomor_kartu' => [
                'nullable',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | MASA BERLAKU
            |--------------------------------------------------------------------------
            */

            'tanggal_terdaftar' => [
                'nullable',
                'date',
            ],

            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_terdaftar',
            ],


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'nonaktif',
                    'ditangguhkan',
                    'berhenti',
                ]),
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

        ];
    }

    public function after(): array
    {
        return [

            function (Validator $validator) {

                $kecamatanId = $this->input('kecamatan_id');
                $kelurahanId = $this->input('kelurahan_id');

                /*
                |--------------------------------------------------------------------------
                | Jika Kelurahan dipilih, Kecamatan juga harus dipilih
                |--------------------------------------------------------------------------
                */

                if ($kelurahanId && ! $kecamatanId) {

                    $validator->errors()->add(
                        'kecamatan_id',
                        'Kecamatan wajib dipilih jika Kelurahan dipilih.'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Pastikan Kelurahan milik Kecamatan
                |--------------------------------------------------------------------------
                */

                if ($kecamatanId && $kelurahanId) {

                    $valid = Kelurahan::query()
                        ->where('id', $kelurahanId)
                        ->where('kecamatan_id', $kecamatanId)
                        ->exists();

                    if (! $valid) {

                        $validator->errors()->add(
                            'kelurahan_id',
                            'Kelurahan yang dipilih tidak berada dalam Kecamatan yang dipilih.'
                        );

                    }

                }

            },

        ];
    }

    public function attributes(): array
    {
        return [

            'jenis_jukir_id' => 'jenis jukir',

            'nik' => 'NIK',
            'nama' => 'nama',
            'tempat_lahir' => 'tempat lahir',
            'tanggal_lahir' => 'tanggal lahir',
            'jenis_kelamin' => 'jenis kelamin',

            'alamat' => 'alamat',
            'kecamatan_id' => 'kecamatan',
            'kelurahan_id' => 'kelurahan',
            'no_hp' => 'nomor HP',

            'foto' => 'foto',
            'foto_ktp' => 'foto KTP',
            'nomor_kartu' => 'nomor kartu',

            'tanggal_terdaftar' => 'tanggal terdaftar',
            'tanggal_berakhir' => 'tanggal berakhir',

            'status' => 'status',
            'keterangan' => 'keterangan',

        ];
    }
}