<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Post extends BaseModel
{
    use Sluggable;

    public function sluggable()
    {
        return [
        'slug' => [
          'source' => 'titulo',
        ],
      ];
    }

    protected $guarded = [
    ];
    protected $appends = [
        'imagemTag',
    ];
    protected $with = ['categoria'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Posts';
    public $newButton = 'Novo Post';

    public $listagem = [
      'Imagem' => 'imagemTag',
      'Categoria' => 'categoria.nome',
      'titulo',
    ];

    public $formulario = [
      'categoriapost_id' => [
        'title' => 'Categoria do post',
        'type' => 'belongs',
        'model' => 'Categoriapost',
        'show' => 'nome',
        'width' => 4,
        'validators' => 'required|int|exists:categoriaposts,id',
      ],
      'titulo' => [
        'title' => 'Título do Post',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:5',
      ],
      'imagem' => [
        'title' => 'Imagem do Post',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],
      'conteudo' => [
        'title' => 'Conteúdo do Post',
        'type' => 'textarea',
        'width' => 12,
        'editor' => true,
        'validators' => 'required',
      ],
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoriapost::class, 'categoriapost_id');
    }
}
