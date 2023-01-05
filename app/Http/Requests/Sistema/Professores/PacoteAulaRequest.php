<?php

namespace App\Http\Requests\Sistema\Professores;

use Illuminate\Foundation\Http\FormRequest;

class PacoteAulaRequest extends FormRequest
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
            'aulaaovivo_id' => 'required|int|exists:aulaaovivos,id',
            'quantidade' => 'required|int|min:2|max:100',
            'desconto' => 'required|numeric|min:1',
        ];
    }
    public function messages()
    {
        return[
            'aulaaovivo_id.required' => 'Selecione a aula!',
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
