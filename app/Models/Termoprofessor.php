<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termoprofessor extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Termos de Uso do Professor';
    public $type = 'page';
    public $formulario = [
        'conteudo' => [
            'title' => 'Texto dos Termos de Uso',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
    ];
}
