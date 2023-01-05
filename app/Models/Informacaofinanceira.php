<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informacaofinanceira extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Instruções do Professor';
    public $type = 'page';
    public $formulario = [
        'video' => [
            'title' => 'Vídeo do Painel de Controle',
            'type' => 'video',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
        'conteudo' => [
            'title' => 'Texto das Informações Financeiras',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:10',
        ],
    ];
}
