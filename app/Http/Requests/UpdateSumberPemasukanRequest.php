<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateSumberPemasukanRequest extends StoreSumberPemasukanRequest
{
    public function rules(): array
    {
        return [
            'kode' => [
                'required',
                'string',
                'max:30',
                Rule::unique('sumber_pemasukans', 'kode')->ignore($this->route('sumberPemasukan')?->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }
}