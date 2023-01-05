<?php

namespace App\Http\Requests\Sistema\Cadastro;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class CadastroProfessorRequest extends FormRequest
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
            'termos' => 'required|int|min:1|max:1',
            'nome' => 'required|string|min:2',
            'sobrenome' => 'required|string|min:2',
            'email' => 'required|email|unique:professoraovivos,email|unique:alunos,email|confirmed',
            'telefone' => 'required|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'whatsapp' => 'nullable|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'senha' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'telefone.regex' => 'Telefone inválido!',
            'whatsapp.regex' => 'Whatsapp inválido!',
            'email.confirmed' => 'Confirmação de e-mail inválida!',
            'email.unique' => 'E-mail já cadastrado!',
            'senha.confirmed' => 'Confirmação de senha inválida!',
        ];
    }

    public function passedValidation()
    {
        return $this->merge([
            'senha' => Hash::make($this->senha),
            'confirmation_token' => Str::random(100),
            'remember_token' => Str::random(100),
        ]);
    }
}
