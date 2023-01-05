<?php

namespace App\Http\Requests\Sistema\Professores;

use Illuminate\Foundation\Http\FormRequest;

class DisponibilidadeProfessorRequest extends FormRequest
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

    public function prepareForValidation()
    {
        return $this->merge([
            'inicio' => dateAppToBd($this->inicio),
            'fim' => dateAppToBd($this->fim),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'inicio' => 'required|date|after:yesterday',
            'fim' => 'required|date|after_or_equal:inicio',
            'dias.0' => 'required|int',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'aluno_id' => 'nullable|exists:alunos,id|int',
        ];
    }

    public function messages()
    {
        return[
            'inicio.required' => 'Data de início obrigatória!',
            'inicio.after' => 'A data de início deve ser maior que ontem!',
            'fim.required' => 'Data de término obrigatória!',
            'fim.after_or_equal' => 'A data de término deve ser maior ou igual a data de início!',
            'dias.0.required' => 'Selecione ao menos um dia da semana!',
            'hora_inicio.required' => 'Hora de início obrigatória!',
            'hora_fim.required' => 'Hora de término obrigatória!',
            'hora_fim.after' => 'A hora de término deve ser maior ou igual a data de início!',
        ];
    }

    public function passedValidation()
    {
        return $this->merge([
            'professoraovivo_id' => $this->user()->id,
            'dias' => implode(',', $this->dias),
        ]);
    }
}
