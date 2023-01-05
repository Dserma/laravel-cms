<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagenoticia extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Página de Notícias';
    public $type = 'page';
    public $formulario = [
    'destaques' => [
      'title' => 'Destaques',
      'type' => 'select-multi',
      'src' => 'model',
      'data' => 'Noticia',
      'show' => 'titulo',
      'json' => true,
      'width' => 12,
      'validators' => 'required|array',
    ],
  ];
}
