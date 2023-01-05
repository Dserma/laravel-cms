<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
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
          'nome' => 'required|string|min:2',
          'telefone' => 'required|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
          'email' => 'required|email',
          'assunto' => 'required|string|min:2',
          'mensagem' => 'required|string|min:10',
        ];
    }
}
