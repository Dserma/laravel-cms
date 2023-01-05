<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AgendaRequest extends FormRequest
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
            'nome' => 'required|string|min:2',
            'email' => 'required|email|unique:agendas,email|unique:empresas,email',
            'telefone' => 'required|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'categorias' => 'required|array',
            'senha' => 'required|string|confirmed|min:6',
            'senha_confirmation' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'categorias.required' => 'CATEGORIA obrigatória!',
            'senha_confirmation.required' => 'CONFIRMAÇÃO obrigatória!',
            'email.unique' => 'E-MAIL já cadastrado! Faça seu login.',
            'senha.confirmed' => 'Confirmação de senha não confere',
            'senha.min' => 'Deve conter ao menos 6 caracteres!',
            'senha_confirmation.min' => 'Deve conter ao menos 6 caracteres!',
        ];
    }

    public function passedValidation()
    {
        return $this->merge([
            'senha' => Hash::make($this->senha),
            'categorias' => json_encode($this->categorias),
        ]);
    }
}
