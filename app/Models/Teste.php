<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teste extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Teste do Wesley';
    public $newButton = 'Novo Teste do Wesleyt';

    public $listagem = [
      'nome',
      'email',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome do teste',
        'type' => 'text',
        'width' => 6,
        'validators' => 'required|string|min:3|unique:testes,nome,$this->id',
      ],
      'email' => [
        'title' => 'E-mail do teste',
        'type' => 'email',
        'width' => 6,
        'validators' => 'required|email',
      ],
    ];
}
