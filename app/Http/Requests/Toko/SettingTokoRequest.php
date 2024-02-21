<?php

namespace App\Http\Requests\Toko;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SettingTokoRequest extends FormRequest
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
            'address' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:100'],
            'motd' => ['required', 'string', 'max:255'],
            'header' => ['required', 'string', 'max:255'],
            'footer' => ['required', 'string'],
        ];
    }
}
