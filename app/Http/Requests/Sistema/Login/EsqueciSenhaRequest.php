<?php

namespace App\Http\Requests\Sistema\Login;

use App\Rules\EmailAlunoProfessor;
use Illuminate\Foundation\Http\FormRequest;

class EsqueciSenhaRequest extends FormRequest
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
            'email' => ['required', 'email', new EmailAlunoProfessor],
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'E-mail inválido!',
            'email.exists' => 'E-mail não cadastrado!',
        ];
    }
}
