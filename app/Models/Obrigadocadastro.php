<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obrigadocadastro extends Model
{
    protected $guarded = [];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Agradecimento de Cadastro';
    public $type = 'page';

    public $formulario = [
        'conteudo' => [
          'title' => 'Texto para usuários gratuitos',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
        'conteudo_pago' => [
          'title' => 'Texto para usuários PAGOS',
          'type' => 'textarea',
          'editor' => true,
          'width' => 12,
          'validators' => 'nullable|string|min:10',
        ],
      ];
}
