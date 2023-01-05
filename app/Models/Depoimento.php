<?php

namespace App\Models;

class Depoimento extends BaseModel
{
    protected $guarded = [];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Depoimentos';
    public $newButton = 'Novo Depoimento';

    public $listagem = [
      'Imagem' => 'imagemTag',
      'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome do Depoente',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3',
      ],
      'imagem' => [
        'title' => 'Imagem do Depoente',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],
      'conteudo' => [
        'title' => 'Conteúdo',
        'type' => 'textarea',
        'editor' => true,
        'width' => 12,
        'validators' => 'required|string|min:3',
      ],
    ];
}
