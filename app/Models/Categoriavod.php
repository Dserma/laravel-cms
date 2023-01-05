<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Categoriavod extends Model
{
    use Sluggable;

    protected $guarded = [];
    protected $appends = [
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de VOD';
    public $newButton = 'Nova categoria';

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nome',
            ],
        ];
    }

    public $listagem = [
        'Categoria' => 'nome',
        'slug',
    ];

    public $formulario = [
        'nome' => [
            'title' => 'Nome da Categoria',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:categoriavods,nome,$this->id',
        ],
    ];

    public function cursos()
    {
        return $this->hasMany(Cursovod::class);
    }

    public function cursosPagos()
    {
        return $this->cursos()->where('gratuito', 0);
    }

    public function cursosGratuitos()
    {
        return $this->cursos()->where('gratuito', 1);
    }
}
