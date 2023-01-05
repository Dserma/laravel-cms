<?php

namespace App\Http\Requests\Sistema\Login;

use Illuminate\Foundation\Http\FormRequest;

class NovaSenha extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'senha' => 'required|string|confirmed|min:3',
        ];
    }

    public function messages()
    {
        return [
            'senha.confirmed' => 'A confirmação de senha não confere com a senha!',
            'senha.min' => 'Mínimo de 3 caracteres!',
        ];
    }
}
