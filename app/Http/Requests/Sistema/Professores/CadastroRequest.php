<?php

namespace App\Http\Requests\Sistema\Professores;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Sistema\BaseRepository;
use Carbon\Carbon;

class CadastroRequest extends FormRequest
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

    public function prepareForValidation()
    {
        return $this->merge([
            'nascimento' => dateAppToBd($this->nascimento),
        ]);
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
            'cpf' => 'required|cpf',
            'nascimento' => 'required|date|before:' . Carbon::now()->subYears(18),
            'telefone' => 'required|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'whatsapp' => 'nullable|regex:/\(\d{2,}\) \d{4,5}\-\d{4}/',
            'email' => 'required|email|unique:alunos,email|unique:professoraovivos,email,' . $this->id,
            'idiomas' => 'nullable',
            'timezone' => 'required|int',
            'categorias' => 'required|array|exists:categoriaaovivos,id',
            'cep' => 'required|regex:/\d{5}\-\d{3}/',
            'logradouro' => 'required|string|min:2',
            'numero' => 'required|string|min:1',
            'bairro' => 'required|string|min:1',
            'state_id' => 'required|string|size:2|exists:states,letter',
            'city_id' => 'required|int|exists:cities,iso',
            'imagem' => 'required|string|min:10',
            'video' => 'nullable|url',
            'titulo_seo' => 'nullable|string|max:255',
            'description_seo' => 'nullable|string|max:1000',
            'keywords_seo' => 'nullable|string|max:1000',
            'apresentacao' => 'required|string|min:20',
            'destaque' => 'required|string|min:20',
            'sobre' => 'required|string|min:20',
            'metodo' => 'nullable|string|min:20',
            'credenciais' => 'nullable|string|min:20',
            'sobre_alunos' => 'required|int|min:1|max:3',
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

    public function messages()
    {
        return[
            'nascimento.before' => 'Você deve ser maior de 18 anos!',
        ];
    }
}
