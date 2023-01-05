<?php

namespace App\Http\Requests\Sistema\Pagamento;

use Illuminate\Foundation\Http\FormRequest;

class CartaoRequest extends FormRequest
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
            'cartao' => 'required|regex:/^\d{4}\.\d{4}\.\d{4}\.\d{4}$/',
            'titular' => 'required|string|min:5',
            'validade' => 'required|date_format:m/y',
            'cvv' => 'required|digits_between:3,4',
            'cpf' => 'required|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
        ];
    }

    public function messages()
    {
        return [
            '*.regex' => ':ATTRIBUTE inválido!',
            'titular.min' => 'Mínimo de 5 caracteres!',
            'validade.date_format' => 'Data inválida!',
            'cvv.digits_between' => 'Entre 3 e 4 números!',
        ];
    }
}
