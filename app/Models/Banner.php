<?php

namespace App\Models;

class Banner extends BaseModel
{
    protected $guarded = [];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Banners da Home';
    public $newButton = 'Novo Banner';

    public $listagem = [
      'Imagem' => 'imagemTag',
      'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome do Banner',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3',
      ],
      'imagem' => [
        'title' => 'Imagem do Banner',
        'type' => 'image',
        'width' => 12,
        'validators' => 'required|string|min:10',
      ],
      'conteudo' => [
        'title' => 'Conteúdo',
        'type' => 'textarea',
        'editor' => true,
        'width' => 12,
        'validators' => 'nullable|string|min:3',
      ],
      'botao' => [
        'title' => 'Texto do Botão',
        'type' => 'text',
        'width' => 6,
        'validators' => 'nullable|string|min:3',
      ],
      'link' => [
        'title' => 'Link do Botão',
        'type' => 'text',
        'width' => 6,
        'validators' => 'nullable|string|min:3',
      ],
    ];
}
