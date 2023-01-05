<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Categoriaaovivo extends Model
{
    use Sluggable;

    protected $guarded = [];
    protected $appends = [
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de Aulas ao Vivo';
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
            'validators' => 'required|string|min:3|unique:categoriaaovivos,nome,$this->id',
        ],
    ];

    public function professores()
    {
        return $this->belongsToMany(Professoraovivo::class);
    }

    public function aulas()
    {
        return $this->hasMany(Aulaaovivo::class);
    }
}
