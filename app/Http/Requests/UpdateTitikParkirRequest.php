<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateTitikParkirRequest extends StoreTitikParkirRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['kode_titik'] = [
            'required',
            'string',
            'max:50',
            Rule::unique('titik_parkirs', 'kode_titik')->ignore(
                $this->route('titik_parkir')?->id ?? $this->route('titikParkir')?->id
            ),
        ];

        return $rules;
    }
}