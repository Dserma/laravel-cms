<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Agenda extends Authenticatable
{
    protected $guarded = [
        'senha_confirmation',
    ];

    protected $with = 'categoria';
    public $hasOrder = false;
    public $hasForm = true;
    public $update = false;
    public $title = 'Agenda de Compras';

    public $listagem = [
        'nome',
        'email',
        // 'Categoria' => 'categoria.nome',
    ];

    public $formulario = [
        'nome' => [
            'title' => 'Nome',
            'type' => 'text',
            'width' => 6,
        ],
        'email' => [
            'title' => 'E-mail',
            'type' => 'text',
            'width' => 6,
        ],
        'telefone' => [
            'title' => 'Telefone',
            'type' => 'text',
            'width' => 6,
        ],
        'categorias' => [
            'title' => 'Categorias de Interesse',
            'type' => 'select-multi',
            'src' => 'model',
            'data' => 'Categoriaproduto',
            'show' => 'nome',
            'json' => true,
            'width' => 6,
            'validators' => 'required|array',
        ],
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function categoria()
    {
        return $this->belongsTo(Categoriaproduto::class, 'categoriaproduto_id');
    }
}
