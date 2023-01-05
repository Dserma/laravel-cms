<?php

namespace App\Http\Requests\Sistema\Professores;

use Illuminate\Foundation\Http\FormRequest;

class NovaCategoriaRequest extends FormRequest
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
            'mensagem' => 'required|min:10',
        ];
    }

    public function messages()
    {
        return [
            'mensagem.min' => 'Digite ao menos 10 caracteres!',
        ];
    }
}
