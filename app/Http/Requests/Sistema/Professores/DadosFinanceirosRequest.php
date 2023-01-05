<?php

namespace App\Http\Requests\Sistema\Professores;

use Illuminate\Foundation\Http\FormRequest;

class DadosFinanceirosRequest extends FormRequest
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
            'tipo_conta_tmp' => 'required|int|min:1|max:2',
            'banco_tmp' => 'required|exists:bancos,id|int',
            'agencia_tmp' => 'required|numeric',
            'agencia_digito_tmp' => 'nullable|numeric|digits_between:0,9',
            'conta_tmp' => 'required|numeric',
            'digito_tmp' => 'required|numeric|digits_between:0,9',
        ];
    }

    public function messages()
    {
        return [
            'agencia.numeric' => 'A agência deve ser numérica!',
            'conta.numeric' => 'A conta deve ser numérica!',
            'digito.numeric' => 'O dígito deve ser numérico!',
        ];
    }
}
