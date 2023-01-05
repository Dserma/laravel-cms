<?php

namespace App\Models;

class Modeloproduto extends BaseModel
{
    protected $guarded = [];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Modelos de Produtos';
    public $newButton = 'Novo modelo';

    public $listagem = [
      'Modelo' => 'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome do Modelo',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:2|unique:categoriaprodutos,nome,$this->id',
      ],
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
