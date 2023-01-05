<?php

namespace App\Http\Requests\Sistema\Pagamento;

use Illuminate\Foundation\Http\FormRequest;

class BoletoRequest extends FormRequest
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
            'cpf' => 'required|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
        ];
    }

    public function messages()
    {
        return [
            '*.regex' => ':ATTRIBUTE inválido!',
        ];
    }
}
