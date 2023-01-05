<?php

namespace App\Models;

class Marcaproduto extends BaseModel
{
    protected $guarded = [];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Marcas de Produtos';
    public $newButton = 'Nova marca';

    public $listagem = [
      'Marca' => 'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome da Marca',
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
