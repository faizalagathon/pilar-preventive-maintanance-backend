<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GambarPemeliharaanRequest extends FormRequest
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
            'gambar.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:20480' // 20 MB (20 * 1024 KB)
        ];
    }

    public function messages(): array
    {
        return [
            'id_pemeliharaan.required' => 'Pemeliharaan di isi',
            'id_pemeliharaan.exists' => 'tidak terdapat data Pemeliharaan tersebut',
            'gambar.*.required' => 'Gambar :index Harus di isi',
            'gambar.*.image' => 'Harus berbentuk gambar',
            'gambar.*.mimes' => 'File ke :index Harus Berekstensi jpeg,jpg,png atau gif',
            'gambar.*.max' => 'Ukuran Maksimal 20 MB'
        ];
    }
}
