<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJenisJukirRequest extends FormRequest
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
            | KODE
            |--------------------------------------------------------------------------
            */

            'kode' => [
                'required',
                'string',
                'max:20',
                Rule::unique('jenis_jukirs', 'kode'),
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