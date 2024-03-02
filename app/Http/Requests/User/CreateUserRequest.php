<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
            'toko' => ['required', 'array', function ($attribute, $value, $fail) {
                if (count($value) !== count(array_unique($value))) {
                    $fail($attribute . ' memiliki nilai yang sama.');
                }
            }],
            'toko.*' => ['integer', 'exists:shops,id'],
        ];
    }
}
