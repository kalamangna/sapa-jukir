<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJenisParkirRequest extends FormRequest
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
                Rule::unique('jenis_parkirs', 'kode'),
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

            'kode' => 'kode jenis parkir',
            'nama' => 'nama jenis parkir',
            'deskripsi' => 'deskripsi',
            'status' => 'status',

        ];
    }
}