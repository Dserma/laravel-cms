<?php

namespace App\Http\Requests\Sistema\Alunos;

use Illuminate\Foundation\Http\FormRequest;

class AvaliacaoRequest extends FormRequest
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
            'ocorreu' => 'required|int|min:1|max:2',
            'comentario_aluno' => 'nullable|required_if:ocorreu,2|string|min:10',
            'rate_professor' => 'nullable|numeric|min:0.5',
        ];
    }

    public function messages()
    {
        return [
            'comentario_aluno.min' => 'Digite ao menos 10 caracteres!',
            'comentario_aluno.required_if' => 'Digite o motivo da aula não ter ocorrido!',
        ];
    }
}
