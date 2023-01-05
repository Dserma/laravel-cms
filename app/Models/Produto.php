<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;

use Cviebrock\EloquentSluggable\Sluggable;

class Produto extends BaseModel
{
    use Sluggable;
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Produtos\ProdutoPresenter';
    protected $guarded = [
        'tipo',
    ];
    protected $appends = [
        'valorFormatado',
        'imagemTag',
    ];
    protected $with = ['empresa', 'categoria'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Produtos';
    public $newButton = 'Novo Produto';

    public function sluggable()
    {
        return [
        'slug' => [
          'source' => ['empresa.nome', 'nome'],
        ],
      ];
    }

    public $listagem = [
      'Imagem' => 'imagemTag',
      'Nome da Empresa' => 'nome',
      'Empresa' => 'empresa.nome',
      'Categoria' => 'categoria.nome',
      'codigo',
      'Valor' => 'valorFormatado',
    ];

    public $formulario = [
      'empresa_id' => [
        'title' => 'Empresa',
        'type' => 'belongs',
        'model' => 'Empresa',
        'show' => 'nome',
        'width' => 12,
        'validators' => 'required|int|exists:empresas,id',
      ],
      'categoriaproduto_id' => [
        'title' => 'Categoria do Produto',
        'type' => 'belongs',
        'model' => 'Categoriaproduto',
        'show' => 'nome',
        'width' => 4,
        'validators' => 'required|int|exists:categoriaprodutos,id',
      ],
      'marcaproduto_id' => [
        'title' => 'Marca do Produto',
        'type' => 'belongs',
        'model' => 'Marcaproduto',
        'show' => 'nome',
        'width' => 4,
        'validators' => 'required|int|exists:marcaprodutos,id',
      ],
      'modeloproduto_id' => [
        'title' => 'Modelo do Produto',
        'type' => 'belongs',
        'model' => 'Modeloproduto',
        'show' => 'nome',
        'width' => 4,
        'validators' => 'required|int|exists:modeloprodutos,id',
      ],
      'nome' => [
        'title' => 'Nome',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:2',
      ],
      'codigo' => [
        'title' => 'Código',
        'type' => 'text',
        'width' => 4,
        'validators' => 'nullable|string|min:1',
      ],
      'ano' => [
        'title' => 'Ano do Produto',
        'type' => 'number',
        'width' => 4,
        'min' => 1900,
        'max' => 2100,
        'step' => 1,
        'validators' => 'required|int|min:1900|max:2100',
      ],
      'valor' => [
        'title' => 'Valor',
        'type' => 'text',
        'width' => 4,
        'class' => 'dinheiro-input-mask',
        'validators' => 'required|numeric|min:0',
      ],
      'imagem' => [
        'title' => 'Imagem Principal',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],
      'resumo' => [
        'title' => 'Resumo do Produto ( aparece na listagem )',
        'type' => 'textarea',
        'width' => 12,
        'editor' => false,
        'limit' => 100,
        'validators' => 'required|string|min:5|max:100',
      ],
      'resumo_interno' => [
        'title' => 'Resumo Interno do Produto ( aparece na na interna do produto, na lateral )',
        'type' => 'textarea',
        'width' => 12,
        'editor' => false,
        'limit' => 100,
        'validators' => 'required|string|min:5|max:100',
      ],
      'descricao' => [
        'title' => 'Descrição',
        'type' => 'textarea',
        'width' => 12,
        'editor' => true,
        'validators' => 'required',
      ],
      'caracteristicas' => [
        'title' => 'Características do Produto ( uma por linha )',
        'type' => 'textarea',
        'width' => 12,
        'editor' => false,
        'limit' => 10000,
        'validators' => 'required|string|min:1',
      ],
    ];

    public function getActions()
    {
        return [
            'images' => [
                'model' => 'Imagemproduto',
                'type' => 'a',
                'color' => 'info',
                'class' => 'btn-images',
                'route' => 'backend.produto.imagens',
                'title' => 'Imagens do ',
                'icon' => 'image',
            ],
        ];
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoriaproduto::class, 'categoriaproduto_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marcaproduto::class, 'marcaproduto_id');
    }

    public function modelo()
    {
        return $this->belongsTo(Modeloproduto::class, 'modeloproduto_id');
    }

    public function imagens()
    {
        return $this->hasMany(Imagemproduto::class);
    }
}
