<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
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
            'code' => ['required', 'integer', 'unique:shops,code'],
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:shops,name'],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode toko wajib diisi.',
            'code.integer' => 'Kode toko harus berupa angka.',
            'code.unique' => "Kode toko ':input' sudah ada.",
            'name.required' => 'Nama toko wajib diisi.',
            'name.min' => 'Nama toko minimal 3 karakter.',
            'name.max' => 'Nama toko maksimal 50 karakter.',
            'name.unique' => "Nama toko ':input' sudah terpakai.",
        ];
    }
}
