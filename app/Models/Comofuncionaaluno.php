<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comofuncionaaluno extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Alunos - Como Funciona';
    public $type = 'page';

    public $formulario = [
        'banner' => [
          'title' => 'Banner da Página "Seja Alumo"',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'titulo' => [
          'title' => 'Título da Seção',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'passos' => [
          'title' => 'Passos',
          'type' => 'repeater',
          'width' => 12,
          'button' => 'Novo Passo',
          'button_d' => 'Remover Passo',
          'validators' => 'nullable|array',
          'fields' => [
            'titulo' => [
              'title' => 'Título',
              'type' => 'text',
              'width' => 12,
              'validators' => 'nullable|string|min:2',
            ],
            'conteudo' => [
              'title' => 'Conteúdo',
              'type' => 'textarea',
              'editor' => true,
              'width' => 12,
              'validators' => 'nullable|string|min:2',
            ],
          ],
        ],
      ];
}
