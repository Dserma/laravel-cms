<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajuda extends Model
{
    protected $guarded = [];
    protected $with = ['categoria'];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Tópicos de Ajuda';
    public $newButton = 'Novo Tópico de Ajuda';

    public $listagem = [
      'Categoria' => 'categoria.nome',
      'titulo',
  ];

    public $formulario = [
      'titulo' => [
        'title' => 'Título do Tópico',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3',
      ],
      'categoriaajuda_id' => [
        'title' => 'Categoria do Tópico',
        'type' => 'belongs',
        'src' => 'model',
        'model' => 'Categoriaajuda',
        'show' => 'nome',
        'width' => 6,
        'validators' => 'required|int|exists:categoriaajudas,id',
      ],
      'conteudo' => [
        'title' => 'Conteúdo',
        'type' => 'textarea',
        'editor' => true,
        'width' => 12,
        'validators' => 'required|string|min:3',
      ],
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoriaajuda::class, 'categoriaajuda_id');
    }
}
