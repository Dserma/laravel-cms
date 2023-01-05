<?php

namespace App\Http\Requests\Sistema\Alunos;

use Illuminate\Foundation\Http\FormRequest;

class PerguntaRequest extends FormRequest
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
            'pergunta' => 'required|string|min:10',
        ];
    }

    public function messages()
    {
        return [
            'pergunta.required' => 'Pergunta obrigatória!',
            'pergunta.min' => 'Mínimo de 10 caracteres!',
        ];
    }
}
