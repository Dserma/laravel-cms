<?php

namespace App\Models;

class Anunciante extends BaseModel
{
    protected $guarded = [];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Anunciantes';
    public $newButton = 'Novo Anunciante';

    public $listagem = [
      'Imagem' => 'imagemTag',
      'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome do Anunciante',
        'type' => 'text',
        'width' => 6,
        'validators' => 'required|string|min:3',
      ],
      'link' => [
        'title' => 'Link do Anunciante',
        'type' => 'url',
        'width' => 6,
        'validators' => 'nullable|string|min:3',
      ],
      'imagem' => [
        'title' => 'Imagem do Banner',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],

    ];
}
