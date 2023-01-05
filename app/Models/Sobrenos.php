<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sobrenos extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Sobre Nós - Textos';
    public $type = 'page';
    public $formulario = [
    'sobre' => [
      'title' => 'Texto de "Sobre Nós"',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
    'conheca' => [
      'title' => 'Texto de "Conheça"',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
    'resumo_historia' => [
      'title' => 'Resumo da História',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
    'descricao' => [
      'title' => 'Descrição da História',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
    'texto_vantagens' => [
      'title' => 'Texto das Vantagens',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
    'vantagens' => [
      'title' => 'Vantagens',
      'type' => 'repeater',
      'width' => 12,
      'button' => 'Nova Vantagem',
      'button_d' => 'Remover Vantagem',
      'validators' => 'nullable|array',
      'fields' => [
        'titulo' => [
          'title' => 'Vantagem',
          'type' => 'text',
          'width' => 12,
          'validators' => 'nullable|string|min:2',
        ],
      ],
    ],
    'missao' => [
      'title' => 'Missão',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
    'visao' => [
      'title' => 'Visão',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
    'valores' => [
      'title' => 'Valores',
      'type' => 'textarea',
      'editor' => true,
      'width' => 12,
      'validators' => 'nullable|string|min:10',
    ],
  ];
}
