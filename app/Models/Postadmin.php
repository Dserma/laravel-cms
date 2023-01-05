<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postadmin extends Model
{
    protected $guarded = [
    ];

    protected $appends = [
        'imagemTag',
        'tipoTag',
    ];

    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Postagens';
    public $newButton = 'Nova Postagem';

    public $listagem = [
        'tipo' => 'tipoTag',
        'imagem' => 'imagemTag',
        'titulo',
    ];

    public $formulario = [
        'tipo' => [
            'title' => 'Tipo',
            'type' => 'radio',
            'width' => 12,
            'src' => 'array',
            'data' => [1 => 'Usuários', 2 => 'Lojas', 3 => 'Ambos'],
            'validators' => 'required|int|min:1|max:3',
        ],
        'titulo' => [
            'title' => 'Título',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'imagem' => [
            'title' => 'Imagem',
            'type' => 'image',
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'conteudo' => [
            'title' => 'Conteúdo',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
    ];

    public function getImagemTagAttribute()
    {
        return $this->attributes['imagemTag'] = '<img src="' . $this->imagem . '" alt="">';
    }

    public function getTipoTagAttribute()
    {
        if ($this->tipo == 1) {
            $tag = '<label for="" class="label label-success">Usuários</label>';
        }
        if ($this->tipo == 2) {
            $tag = '<label for="" class="label label-danger">Lojas</label>';
        }
        if ($this->tipo == 3) {
            $tag = '<label for="" class="label label-primary">Ambos</label>';
        }

        return $this->attributes['tipoTag'] = $tag;
    }
}
