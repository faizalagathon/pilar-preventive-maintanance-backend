<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DaftarPemeliharaanRequest extends FormRequest
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
            'id_pemeliharaan' => 'required|exists:pemeliharaan,id',
            'id_kegiatan_pemeliharaan' => 'required|exists:kegiatan_pemeliharaan,id'
        ];
    }
    // Pesan
    public function messages(): array
    {
        return [
            'id_pemeliharaan.required' => ' Pemeliharaan di isi',
            'id_pemeliharaan.exists' => 'tidak terdapat data Pemeliharaan tersebut',

            'id_kegiatan_pemeliharaan.required' => 'Kegiatan Pemeliharaan di isi',
            'id_kegiatan_pemeliharaan.exists' => 'tidak terdapat data Kegiatan Pemeliharaan tersebut'
        ];
    }
}
