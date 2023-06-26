<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [];
    public $listagem = [
        'categoria' => 'categoria.nome',
        'titulo'
    ];
    public $withAdmin = [
        'categoria'
    ];
    public $newButton = 'Novo Post';
    public $title = 'Posts';
    public $hasForm = true;
    public $update = true;
    public $formulario = [
        'categoria_id' => [
            'title' => 'Categoria',
            'type' => 'belongs',
            'model' => 'Categoria',
            'show' => 'nome',
            'width' => 4,
            'validators' => 'required|int|exists:categorias,id',
        ],
        'titulo' => [
            'title' => 'Título',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:2|unique:posts,titulo,$this->id',
        ],
        'imagem' => [
            'title' => 'Imagem do Post:*',
            'type' => 'image',
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'conteudo' => [
            'title' => 'Conteúdo do Post',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
        ],
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

}
