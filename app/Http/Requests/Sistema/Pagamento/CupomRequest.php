<?php

namespace App\Http\Requests\Sistema\Pagamento;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cupom' => 'required|exists:cupoms,slug',
        ];
    }

    public function messages()
    {
        return [
            'cupom.exists' => 'Este cupom não existe!',
        ];
    }
}
