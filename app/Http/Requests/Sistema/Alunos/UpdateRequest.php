<?php

namespace App\Http\Requests\Sistema\Alunos;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Sistema\BaseRepository;

class UpdateRequest extends FormRequest
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
            'sobrenome' => 'required|string|min:2',
            'email' => 'required|email|unique:alunos,email,' . $this->id,
            'telefone' => 'required|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'whatsapp' => 'required|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'pais' => 'required|int|min:1|max:2',
            'cep' => 'nullable|regex:/\d{5}\-\d{3}/',
            'logradouro' => 'nullable|string|min:2',
            'numero' => 'nullable|string|min:1',
            'complemento' => 'nullable|string|min:1',
            'bairro' => 'nullable|string|min:2',
            'state_id' => 'nullable|string|size:2|exists:states,letter',
            'city_id' => 'nullable|int|exists:cities,iso',
            'senha' => 'nullable|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'telefone.regex' => 'Telefone inválido!',
            'whatsapp.regex' => 'Telefone inválido!',
            'cep.regex' => 'Cep inválido!',
            'state_id.required' => 'ESTADO obrigatório!',
            'city_id.required' => 'CIDADE obrigatória!',
            'senha.confirmed' => 'Confirmação de senha inválida!',
        ];
    }

    public function passedValidation()
    {
        if ($this->senha) {
            $this->merge([
                'senha' => Hash::make($this->senha),
                'remember_token' => Str::random(100),
            ]);
        }

        if ($this->state_id) {
            return $this->merge([
                'state_id' => BaseRepository::get('estado', ['letter' => $this->state_id])->first()->id,
                'city_id' => BaseRepository::get('cidade', ['iso' => $this->city_id])->first()->id,
            ]);
        }
    }
}
