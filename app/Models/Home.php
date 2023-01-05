<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Home - Textos';
    public $type = 'page';

    public $formulario = [
        'titulo_cursos' => [
          'title' => 'Título da dos Cursos',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'subtitulo_cursos' => [
          'title' => 'Subtítulo da dos Cursos',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'box_professores_cursos' => [
          'title' => 'Texto do box de professores dos cursos',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'titulo_depoimentos' => [
          'title' => 'Título dos depoimentos',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'titulo_professores' => [
          'title' => 'Título dos professores',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'subtitulo_professores' => [
          'title' => 'Subtítulo dos professores',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'texto_professores' => [
          'title' => 'Texto dos professores',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
      ];
}
