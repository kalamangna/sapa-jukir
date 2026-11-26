<?php

namespace App\Http\Requests;

use App\Models\Setoran;

class UpdateSetoranRequest extends StoreSetoranRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $setoran = $this->route('setoran');
        if (!$setoran instanceof Setoran && $setoran) {
            $setoran = Setoran::find($setoran);
        }

        if ($setoran && !$setoran->karcisUsages()->exists()) {
            $rules['karcis_lines'] = ['nullable', 'array', 'max:10'];
            $rules['karcis_lines.*.allocation_id'] = ['required_with:karcis_lines', 'integer', 'exists:karcis_allocations,id'];
            $rules['karcis_lines.*.nomor'] = ['required_with:karcis_lines', 'string', 'max:20000'];
        }

        return $rules;
    }
}