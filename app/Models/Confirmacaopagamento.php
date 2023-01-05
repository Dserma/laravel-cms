<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmacaopagamento extends Model
{
    protected $guarded = [];
    protected $table = 'confirmacao_pagamentos';

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Confirmação de Pagamento';
    public $type = 'page';

    public $formulario = [
        'conteudo' => [
          'title' => 'Conteúdo da Página',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
      ];
}
