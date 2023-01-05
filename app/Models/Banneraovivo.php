<?php

namespace App\Models;

class Banneraovivo extends Basemodel
{
    protected $guarded = [];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Banner AO VIVO Para Alunos';
    public $newButton = 'Novo Banner';

    public $listagem = [
      'Imagem' => 'imagemTag',
    ];

    public $formulario = [
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
        'validators' => 'required|string|min:3',
      ],
      'link' => [
        'title' => 'Link do Botão',
        'type' => 'url',
        'width' => 6,
        'validators' => 'required|string|min:3',
      ],
    ];
}
