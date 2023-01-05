<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $guarded = [];

    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de Posts';
    public $newButton = 'Nova Categoria de Post';

    public $listagem = [
      'Categoria de Post' => 'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome da Categoria de Post',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3|unique:categorias,nome,$this->id',
      ],
    ];
}
