<?php

namespace App\Http\Requests\Backend\Login;

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
          'usuario' => 'required|string|min:3|exists:users,usuario',
          'senha' => 'required|string|min:6'
        ];
    }

    function messages(){
      return [
        'usuario.exists' => 'Usuário não encontrado!',
      ];
    }
}
