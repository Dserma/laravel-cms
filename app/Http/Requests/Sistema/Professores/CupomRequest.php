<?php

namespace App\Http\Requests\Sistema\Professores;

use Illuminate\Foundation\Http\FormRequest;

class CupomRequest extends FormRequest
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
            'validade' => dateAppToBd($this->validade),
            'desconto' => currencyToBd($this->desconto),
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
            'categoriaaovivo_id' => 'required|int|exists:categoriaaovivos,id',
            'aulaaovivo_id' => 'required|int|exists:aulaaovivos,id',
            'validade' => 'required|date|after:yesterday',
            'desconto' => 'required|numeric|min:1',
        ];
    }
    public function messages()
    {
        return[
            'categoriaaovivo_id.required' => 'Selecione a categoria!',
            'aulaaovivo_id.required' => 'Selecione a aula!',
            'validade.after' => 'A data de validade tem que ser maior que ontem!',
            'desconto.min' => 'Desconto deve ser maior que 1%!',
        ];
    }

    public function passedValidation()
    {
        return $this->merge([
            'professoraovivo_id' => $this->user()->id,
        ]);
    }
}
