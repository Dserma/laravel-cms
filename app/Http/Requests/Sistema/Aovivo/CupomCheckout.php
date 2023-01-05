<?php

namespace App\Http\Requests\Sistema\Aovivo;

use Illuminate\Foundation\Http\FormRequest;

class CupomCheckout extends FormRequest
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
            'cupom' => 'required|string|exists:cupomaovivos,slug',
        ];
    }

    public function messages()
    {
        return[
            'cupom.exists' => 'Cupom Inválido!',
        ];
    }
}
