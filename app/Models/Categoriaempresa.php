<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoriaempresa extends Model
{
    protected $guarded = [];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de Empresas';
    public $newButton = 'Nova categoria';

    public $listagem = [
      'Categoria' => 'nome',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome da Categoria',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3|unique:categoriaempresas,nome,$this->id',
      ],
    ];

    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
}
