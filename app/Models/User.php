<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [
      'csenha',
    ];
    protected $hidden = [
      'senha',
      'remember_token',
    ];
    public $listagem = [
      'nome',
      'Usuário' => 'usuario',
      'email',
    ];
    public $newButton = 'Novo Usuário';
    public $title = 'Usuários';
    public $hasForm = true;
    public $update = true;
    public $formulario = [
      'nome' => [
        'title' => 'Nome',
        'type' => 'text',
        'width' => 6,
      ],
      'usuario' => [
        'title' => 'Usuário',
        'type' => 'text',
        'width' => 6,
      ],
      'email' => [
        'title' => 'E-mail',
        'type' => 'email',
        'width' => 12,
      ],
      'senha' => [
        'title' => 'Senha',
        'type' => 'password',
        'main' => true,
        'token' => 'remember_token',
        'token_size' => 60,
        'width' => 6,
      ],
      'csenha' => [
        'title' => 'Confirmar Senha',
        'type' => 'password',
        'width' => 6,
        'validators' => 'required_with:senha|same:senha',
      ],
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
