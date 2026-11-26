<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJenisJukirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jenisJukir = $this->route('jenis_jukir');

        return [

            /*
            |--------------------------------------------------------------------------
            | KODE
            |--------------------------------------------------------------------------
            */

            'kode' => [
                'required',
                'string',
                'max:20',
                Rule::unique('jenis_jukirs', 'kode')
                    ->ignore($jenisJukir),
            ],


            /*
            |--------------------------------------------------------------------------
            | NAMA
            |--------------------------------------------------------------------------
            */

            'nama' => [
                'required',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | DESKRIPSI
            |--------------------------------------------------------------------------
            */

            'deskripsi' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }


    public function attributes(): array
    {
        return [

            'kode' => 'kode jenis jukir',
            'nama' => 'nama jenis jukir',
            'deskripsi' => 'deskripsi',
            'status' => 'status',

        ];
    }
}