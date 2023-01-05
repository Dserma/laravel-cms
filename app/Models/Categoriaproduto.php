<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Categoriaproduto extends BaseModel
{
    use Sluggable;

    protected $guarded = [];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de Produtos';
    public $newButton = 'Nova categoria';

    protected $appends = [
      'imagemTag',
    ];

    public $listagem = [
      'Imagem' => 'imagemTag',
      'Categoria' => 'nome',
    ];

    public function sluggable()
    {
        return [
        'slug' => [
          'source' => 'nome',
        ],
      ];
    }

    public $formulario = [
      'nome' => [
        'title' => 'Nome da Categoria',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3|unique:categoriaprodutos,nome,$this->id',
      ],
      'imagem' => [
        'title' => 'Imagem da Categoria',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
