<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'email' => 'required|email|unique:newsletters,email',
        ];
    }

    public function messages()
    {
        return [
            'nome.min' => 'Mínimo de 2 caracteres',
            'email.unique' => 'E-mail já cadastrado!',
        ];
    }
}
