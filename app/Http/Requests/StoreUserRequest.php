<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash:ascii', 'min:3', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', Password::min(8)->letters()->numbers(), 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'operator', 'pimpinan'])],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];
    }
}
