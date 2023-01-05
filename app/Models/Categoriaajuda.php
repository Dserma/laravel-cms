<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoriaajuda extends Model
{
    protected $guarded = [];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de Ajuda';
    public $newButton = 'Nova Categoria';

    public $listagem = [
      'nome',
  ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome da categoria',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3|unique:categoriaajudas,nome,$this->id',
      ],
    ];
}
