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
            'site_address' => ['required', 'string'],
            'site_name' => ['required', 'string'],
            'note_header' => ['required', 'string'],
            'site_motd' => ['required', 'string'],
            'note_footer' => ['required', 'string'],
        ];
    }
}
