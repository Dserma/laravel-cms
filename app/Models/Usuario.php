<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $hidden = [
      'senha',
      'reset_token',
    ];

    protected $guarded = [
      'declaracao',
      'senha_confirmation',
      'imagem',
    ];

    protected $appends = [
      'imagemTag',
      'status',
      'firstName',
    ];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = false;
    public $title = 'Usuários';

    public $listagem = [
      'imagem' => 'imagemTag',
      'nome',
      'e-mail' => 'email',
      'telefone',
      'status',
    ];

    public $formulario = [
      'imagem' => [
        'title' => 'Imagem',
        'type' => 'icon',
        'width' => 6,
        'validators' => 'required|string|min:3',
      ],
      'nome' => [
        'title' => 'Nome',
        'type' => 'text',
        'width' => 6,
        'validators' => 'required|string|min:3',
      ],
      'email' => [
        'title' => 'E-mail',
        'type' => 'text',
        'width' => 6,
        'validators' => 'required|email|min:3',
      ],
      'cep' => [
        'title' => 'CEP',
        'type' => 'text',
        'width' => 3,
        'validators' => 'required|url|min:3',
      ],
      'endereco' => [
        'title' => 'Endereço',
        'type' => 'text',
        'width' => 6,
        'validators' => 'required|url|min:3',
      ],
      'telefone' => [
        'title' => 'Telefone',
        'type' => 'text',
        'width' => 3,
        'validators' => 'required|url|min:3',
      ],
    ];

    public function loja()
    {
        return $this->hasOne(Loja::class);
    }

    public function seguidas()
    {
        return $this->belongsToMany(Loja::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function cupons()
    {
        return $this->hasMany(Cupom::class);
    }

    public function curtidos()
    {
        return $this->belongsToMany(Post::class);
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getImagemTagAttribute()
    {
        return $this->attributes['imagemTag'] = '<img src="' . $this->imagem . '" />';
    }

    public function getStatusAttribute()
    {
        if ($this->confirmation_token === null) {
            $tag = '<label class="label label-success">Confirmado</label>';
        } else {
            $tag = '<label class="label label-danger">Aguardando Confirmação</label>';
        }

        return $this->attributes['status'] = $tag;
    }

    public function getFirstNameAttribute()
    {
        $nome = explode(' ', $this->nome);

        return $this->attributes['firstName'] = reset($nome);
    }
}
