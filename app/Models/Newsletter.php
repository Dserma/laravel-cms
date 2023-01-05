<?php

namespace App\Models;

class Newsletter extends BaseModel
{
    protected $guarded = [
    ];
    protected $appends = [
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = false;
    public $title = 'Newsletter';

    public $listagem = [
        'nome',
        'email',
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
    ];
}
