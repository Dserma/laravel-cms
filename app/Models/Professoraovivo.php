<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Professoraovivo extends Authenticatable
{
    use Notifiable;
    use Sluggable;
    use PresentableTrait;

    protected $guarded = [
        'email_confirmation',
        'senha_confirmation',
        'categorias',
        'fullName',
    ];
    protected $hidden = [
        'senha',
    ];
    protected $appends = [
        'statusTag',
        'fullName',
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $serverSide = false;
    public $title = 'Professores de Aulas ao Vivo';
    public $newButton = 'Novo professor';
    public $searchAdmin = [
        'nome',
        'sobrenome',
        'email',
    ];
    protected $presenter = 'App\Presenters\Professores\ProfessorPresenter';

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['nome', 'sobrenome'],
            ],
        ];
    }

    public $listagem = [
        'nome',
        'sobrenome',
        'email',
        'telefone',
        'whatsapp',
        'status' => 'statusTag',
    ];

    public $formulario = [
        'basicos' => [
            'title' => 'Dados Básicos',
            'type' => 'fieldset',
        ],
        'nome' => [
            'title' => 'Nome',
            'type' => 'text',
            'width' => 3,
            'validators' => 'required|string|min:3',
        ],
        'sobrenome' => [
            'title' => 'Sobrenome',
            'type' => 'text',
            'width' => 3,
            'validators' => 'required|string|min:3',
        ],
        'telefone' => [
            'title' => 'Telefone',
            'type' => 'text',
            'width' => 3,
            'class' => 'telefone-input-mask',
            'validators' => 'nullable|string|min:3',
        ],
        'whatsapp' => [
            'title' => 'Whatsapp',
            'type' => 'text',
            'width' => 3,
            'class' => 'telefone-input-mask',
            'validators' => 'nullable|string|min:3',
        ],
        'email' => [
            'title' => 'E-mail',
            'type' => 'text',
            'width' => 3,
            'validators' => 'required|email|unique:alunos,email|unique:professoraovivos,email,$this->id',
        ],
        'timezone' => [
            'title' => 'Timezone',
            'type' => 'belongs',
            'model' => 'Zona',
            'id' => 'zone_id',
            'show' => 'zone_name',
            'width' => 3,
            'validators' => 'required|int|exists:zones,zone_id',
        ],
        'endereco' => [
            'title' => 'Endereço',
            'type' => 'fieldset',
        ],
        'cep' => [
            'title' => 'CEP',
            'type' => 'text',
            'width' => 2,
            'class' => 'cep-input-mask',
            'validators' => 'required|regex:/\d{5}\-\d{3}/',
        ],
        'logradouro' => [
            'title' => 'Logradouro',
            'type' => 'text',
            'width' => 6,
            'validators' => 'required|string|min:2',
        ],
        'numero' => [
            'title' => 'Número',
            'type' => 'text',
            'width' => 2,
            'validators' => 'required|string|min:2',
        ],
        'complemento' => [
            'title' => 'Copmplemento',
            'type' => 'text',
            'width' => 2,
            'validators' => 'nullable|string|min:2',
        ],
        'bairro' => [
            'title' => 'Bairro',
            'type' => 'text',
            'width' => 4,
            'validators' => 'nullable|string|min:1',
        ],
        'city_id' => [
            'title' => 'Cidade',
            'type' => 'belongs',
            'model' => 'Cidade',
            'show' => 'title',
            'width' => 4,
            'validators' => 'required|int|exists:cities,id',
        ],
        'state_id' => [
            'title' => 'Estado',
            'type' => 'belongs',
            'model' => 'Estado',
            'show' => 'title',
            'width' => 4,
            'validators' => 'required|int|exists:states,id',
        ],
        'senha' => [
            'title' => 'Digite uma senha para o Professor',
            'type' => 'password',
            'main' => true,
            'token' => 'remember_token',
            'token_size' => 60,
            'width' => 4,
            'validators' => 'nullable|string|min:6',
        ],
        'sobre' => [
            'title' => 'Sobre o Professor',
            'type' => 'fieldset',
        ],
        'imagem' => [
            'title' => 'Imagem',
            'type' => 'icon',
            'width' => 12,
            'validators' => 'required|string|min:10',
        ],
        'video' => [
            'title' => 'Vídeo',
            'type' => 'text',
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
        'destaque' => [
            'title' => 'Texto de Destaque',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:10',
        ],
        'apresentacao' => [
            'title' => 'Texto de Apresentação',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:10',
        ],
        'sobre' => [
            'title' => 'Texto de Sobre',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
        'metodo' => [
            'title' => 'Texto do Método de Ensino',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
        'credenciais' => [
            'title' => 'Texto de Credenciais e Afiliações',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
        'sobre_alunos' => [
            'title' => 'Dá aula a menores de 18 anos?',
            'type' => 'radio',
            'width' => 6,
            'src' => 'array',
            'data' => [1 => 'SIM', 2 => 'NÃO'],
            'default' => 1,
            'validators' => 'required|int|min:1|max:3',
        ],
        'situacao' => [
            'title' => 'Status',
            'type' => 'fieldset',
        ],
        'status' => [
            'title' => 'Status do Professor',
            'type' => 'radio',
            'width' => 6,
            'src' => 'array',
            'data' => [0 => 'Em análise', 1 => 'Aprovado', 2 => 'Bloqueado'],
            'default' => 0,
            'validators' => 'required|int|min:0|max:2',
        ],
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoriaaovivo::class);
    }

    public function aulas()
    {
        return $this->hasMany(Aulaaovivo::class);
    }

    public function pacotes()
    {
        return $this->hasMany(Pacoteaulaaovivo::class);
    }

    public function cupons()
    {
        return $this->hasMany(Cupomaovivo::class);
    }

    public function imagens()
    {
        return $this->hasMany(Imagemprofessoraovivo::class);
    }

    public function disponibilidades()
    {
        return $this->hasMany(Disponibilidadeprofessoraovivo::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'city_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'state_id');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamentoaovivo::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacaoaovivo::class);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['fullName'] = $this->nome . ' ' . $this->sobrenome;
    }

    public function getStatusTagAttribute()
    {
        switch ($this->status) {
            case 0:
                $tag = '<label for="" class="label label-warning">Em Análise</label>';

                break;

            case 1:
                $tag = '<label for="" class="label label-success">Ativo</label>';

                break;

            case 2:
                $tag = '<label for="" class="label label-danger">Bloqueado</label>';

                break;

            case 8:
                $tag = '<label for="" class="label label-primary">MODERAR</label>';

                break;

            default:
                # code...
                break;
        }

        return $this->attributes['statusTag'] = $tag;
    }
}
