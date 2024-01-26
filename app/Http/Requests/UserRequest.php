<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if(request()->isMethod('post')){
            return [
                'id' => Str::uuid(),
                'username'=>'required|string|max:255|unique:user,username',
                'password' => 'required|string|max:255',
                'role'=>'required |string|max:255'
            ];
        }else{
            return [
                // 'id' => Str::uuid(),
                'username'=>'required|string|max:255|unique:user,username,' . request('id'),
                // 'password' => 'required|string|max:255',
                'role'=>'required'
            ];
        }
    }

    public function messages(): array
    {
        return[
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'username telah digunakan.',
            'password.required' => 'Password harus diisi.',
            'username.string' => 'Username harus berupa teks.',
            'password.string' => 'Password harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari :max karakter.',
            'password.max' => 'Password tidak boleh lebih dari :max karakter.'
        ];
    }
}
