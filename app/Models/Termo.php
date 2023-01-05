<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termo extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Termos de Uso';
    public $type = 'page';
    public $formulario = [
        'titulo' => [
            'title' => 'Título',
            'type' => 'text',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:5',
        ],
        'subtitulo' => [
            'title' => 'Subtítulo',
            'type' => 'text',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:5',
        ],
        'conteudo' => [
            'title' => 'Texto dos Termos de Uso',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
    ];
}
