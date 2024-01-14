<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemeliharaanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_barang_inventaris' => 'required|exists:barang_inventaris,id',
            'catatan' => 'max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'id_barang_inventaris.required' => 'Barang Inventaris di isi',
            'id_barang_inventaris.exists' => 'tidak terdapat data Barang Inventaris tersebut',
            'catatan.max' => 'Catatan Maksimal 255 Karakter'
        ];
    }
}
