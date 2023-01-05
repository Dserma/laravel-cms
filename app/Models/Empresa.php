<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Empresa extends Authenticatable
{
    use PresentableTrait;
    use Sluggable;

    protected $guarded = [
        'tipo',
        'senha_confirmation',
    ];
    protected $hidden = [
      'senha',
      'remember_token',
    ];
    protected $appends = [
      'statusTag',
    ];
    protected $dates = [
      // 'validade_assinatura',
    ];
    protected $presenter = 'App\Presenters\Empresas\EmpresaPresenter';
    protected $with = 'plano';
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Empresas';
    public $newButton = 'Nova Empresa';

    public function sluggable()
    {
        return [
        'slug' => [
          'source' => 'nome',
        ],
      ];
    }

    public $listagem = [
      'nome',
      'telefone',
      'email',
      'Plano' => 'plano.nome',
      'Status' => 'statusTag',
      'Valido Até' => 'validade_assinatura',
    ];

    public $formulario = [
      'categoriaempresa_id' => [
        'title' => 'Categoria da Empresa',
        'type' => 'belongs',
        'model' => 'Categoriaempresa',
        'show' => 'nome',
        'width' => 4,
        'validators' => 'required|int|exists:categoriaempresas,id',
      ],
      'plano_id' => [
        'title' => 'Plano da Empresa',
        'type' => 'belongs',
        'model' => 'Plano',
        'show' => 'nome',
        'width' => 4,
        'validators' => 'required|int|exists:planos,id',
      ],
      'validade_assinatura' => [
        'title' => 'Validade da Assinatura',
        'type' => 'text',
        'width' => 4,
        'class' => 'data-input-mask',
        'validators' => 'required|date_format:d/m/Y',
      ],
      'cnpj' => [
        'title' => 'CNPJ',
        'type' => 'text',
        'width' => 3,
        'class' => 'cnpj-input-mask',
        'validators' => 'required|regex:/\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}/|unique:empresas,cnpj,$this->id',
      ],
      'nome' => [
        'title' => 'Nome',
        'type' => 'text',
        'width' => 9,
        'validators' => 'required|string|min:5',
      ],
      'telefone' => [
        'title' => 'Telefone',
        'type' => 'text',
        'width' => 4,
        'class' => 'telefone-input-mask',
        'validators' => 'required|string|min:9',
      ],
      'email' => [
        'title' => 'E-mail',
        'type' => 'email',
        'width' => 4,
        'validators' => 'required|email',
      ],
      'contato' => [
        'title' => 'Contato',
        'type' => 'text',
        'width' => 4,
        'validators' => 'required|string|min:2',
      ],
      'cep' => [
        'title' => 'CEP',
        'type' => 'text',
        'width' => 2,
        'class' => 'cep-input-mask',
        'validators' => 'required|string|min:9',
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
        'validators' => 'required|string|min:1',
      ],
      'complemento' => [
        'title' => 'Complemento',
        'type' => 'text',
        'width' => 2,
        'validators' => 'nullable|string|min:1',
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
        'title' => 'Senha',
        'type' => 'password',
        'main' => true,
        'token' => 'remember_token',
        'token_size' => 60,
        'width' => 6,
      ],
      'senha_confirmation' => [
        'title' => 'Confirmação de Senha',
        'type' => 'password',
        'width' => 6,
        'validators' => 'required_with:senha|same:senha',
      ],
      'descricao' => [
        'title' => 'Descrição',
        'type' => 'textarea',
        'width' => 12,
        'editor' => true,
        'validators' => 'required',
      ],
      'imagem' => [
        'title' => 'Imagem da Empresa',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function categoria()
    {
        return $this->belongsTo(Categoriaempresa::class, 'categoriaempresa_id');
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'city_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'state_id');
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'plano_id');
    }

    public function getStatusTagAttribute()
    {
        switch ($this->status_pedido) {
        case 0:
          $tag = '<label for="" class="label label-warning">Aguardando</label>';

          break;

        case 1:
          $tag = '<label for="" class="label label-success">Ativo</label>';

          break;

        default:
          # code...
          break;
      }

        return $this->attributes['statusTag'] = $tag;
    }
}
