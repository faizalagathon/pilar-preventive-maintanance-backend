<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KegiatanPemeliharaanRequest extends FormRequest
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
            'nama_kegiatan' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'id_kategori_pemeliharaan.required' => 'Kategori Pemeliharaan di isi',
            'id_kategori_pemeliharaan.exists' => 'tidak terdapat data Kategori Pemeliharaan tersebut',
            'nama_kegiatan.required' => 'Nama kegiatan harus di isi'
        ];
    }
}
