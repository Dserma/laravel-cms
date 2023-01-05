<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Noticia extends BaseModel
{
    use Sluggable;

    protected $guarded = [
        'tags',
    ];
    protected $with = ['categoria'];
    protected $appends = [
        'imagemTag',
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Notícias';
    public $newButton = 'Nova notícia';

    public function sluggable()
    {
        return [
        'slug' => [
          'source' => 'titulo',
        ],
      ];
    }

    public $listagem = [
      'Imagem' => 'imagemTag',
      'titulo',
      'Categoria' => 'categoria.nome',
    ];

    public $formulario = [
      'titulo' => [
        'title' => 'Título da Notícia',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3',
      ],
      'categorianoticia_id' => [
        'title' => 'Categoria da Notícia',
        'type' => 'belongs',
        'model' => 'Categorianoticia',
        'show' => 'nome',
        'width' => 4,
        'validators' => 'required|int|exists:categorianoticias,id',
      ],
      'tags' => [
        'title' => 'Tags',
        'type' => 'manyTo',
        'model' => 'Tag',
        'show' => 'nome',
        'width' => 8,
        'validators' => 'required|exists:tags,id',
      ],
      'conteudo' => [
        'title' => 'Conteúdo da notícia',
        'type' => 'textarea',
        'width' => 12,
        'editor' => true,
        'validators' => 'required|string|min:10',
      ],
      'imagem' => [
        'title' => 'Imagem da Notícia',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],
    ];

    public function categoria()
    {
        return $this->belongsTo(Categorianoticia::class, 'categorianoticia_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
