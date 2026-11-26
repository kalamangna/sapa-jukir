<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends StoreUserRequest
{
    public function rules(): array
    {
        $isSelf = $this->route('user')?->is($this->user()) ?? false;

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash:ascii', 'min:3', 'max:50', Rule::unique('users', 'username')->ignore($this->route('user')?->id)],
            'password' => ['nullable', 'string', Password::min(8)->letters()->numbers(), 'confirmed'],
            'role' => [Rule::requiredIf(! $isSelf), 'nullable', Rule::in(['admin', 'operator', 'pimpinan'])],
            'status' => [Rule::requiredIf(! $isSelf), 'nullable', Rule::in(['aktif', 'nonaktif'])],
        ];
    }
}
