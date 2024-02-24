<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->level == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['nullable', 'integer'],
            'name' => ['nullable', 'string', 'min:3', 'max:50'],
        ];
    }

    public function messages()
    {
        return [
            'code.integer' => 'Kode toko harus berupa angka.',
            'name.min' => 'Nama toko minimal 3 karakter.',
            'name.max' => 'Nama toko maksimal 50 karakter.',
        ];
    }
}
