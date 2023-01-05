<?php

namespace App\Http\Requests\Sistema\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginAgendaRequest extends FormRequest
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
            'email' => 'required|email|exists:agendas,email',
            'senha' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'E-mail inválido!',
            'email.exists' => 'E-mail não encontrado em nossa base de dados!',
        ];
    }
}
