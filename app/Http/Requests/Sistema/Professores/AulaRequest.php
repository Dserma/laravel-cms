<?php

namespace App\Http\Requests\Sistema\Professores;

use Illuminate\Foundation\Http\FormRequest;

class AulaRequest extends FormRequest
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
            'valor' => currencyToBd($this->valor),
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
            'duracao' => 'required|int|min:15|max:240',
            'valor' => 'required|numeric|min:10',
        ];
    }

    public function passedValidation()
    {
        return $this->merge([
            'professoraovivo_id' => $this->user()->id,
        ]);
    }
}
