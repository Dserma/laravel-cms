<?php

namespace App\Http\Requests\Sistema\Login;

use App\Rules\ExistshereOr;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'email', new ExistshereOr],
            'senha' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'E-mail inválido!',
            'email.exists' => 'E-mail não cadastrado!',
        ];
    }
}
