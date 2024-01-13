<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangInventarisRequest extends FormRequest
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
            'id_kategori_pemeliharaan' => 'required|exists:kategori_pemeliharaan,id',
            'nama' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_kategori_pemeliharaan.required' => 'Kategori Pemeliharaan harus di isi',
            'id_kategori_pemeliharaan.exists' => 'Kategori Pemeliharaan tersebut tidak ada',
            'nama.required' => 'Nama Barang harus di isi',
        ];
    }
}
