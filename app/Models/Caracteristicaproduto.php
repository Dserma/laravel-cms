<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristicaproduto extends Model
{
    protected $guarded = [];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de Produtos';
    public $newButton = 'Nova categoria';

    public $listagem = [
      'Categoria' => 'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome da Categoria',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3|unique:categoriaprodutos,nome,$this->id',
      ],
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
