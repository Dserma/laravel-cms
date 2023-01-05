<?php

namespace App\Http\Requests\Sistema\Cadastro;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class CadastroRequest extends FormRequest
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
            'plano_id' => 'required|exists:planos,id',
            'nome' => 'required|string|min:2',
            'sobrenome' => 'required|string|min:2',
            'email' => 'required|email|unique:alunos,email|unique:professoraovivos,email|confirmed',
            'pais' => 'required|int|min:1|max:2',
            // 'documento' => 'required_unless:pais,BR|string|min:3',
            // 'ddi' => 'required_unless:pais,BR|string|min:3',
            // 'telefone' => 'required_unless:pais,BR|string|min:4',
            'whatsapp' => 'required|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'senha' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'plano_id.required' => 'Escolha um Plano!',
            'telefone.regex' => 'Telefone inválido!',
            'whatsapp.regex' => 'Whatsapp inválido!',
            'email.confirmed' => 'Confirmação de e-mail inválida!',
            'email.unique' => 'E-mail já cadastrado!',
            'senha.confirmed' => 'Confirmação de senha inválida!',
            'pais.min' => 'Selecione seu país!',
            // 'documento.required_unless' => 'Número do documento obrigatório!',
            // 'ddi.required_unless' => 'Número do DDI obrigatório!',
            // 'telefone.required_unless' => 'Número do telefone obrigatório!',
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
