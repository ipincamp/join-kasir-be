<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class SettingShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (int)auth()->user()->level <= 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'alamat_toko' => ['required', 'string', 'max:255'],
            'nama_toko' => ['required', 'string', 'max:50'],
            'motd_toko' => ['required', 'string', 'max:100'],
            'nota_atas' => ['required', 'string'],
            'nota_bawah' => ['required', 'string'],
        ];
    }
}
