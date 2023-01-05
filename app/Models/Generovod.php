<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Generovod extends Model
{
    use Sluggable;

    protected $guarded = [];
    protected $appends = [
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Gêneros de VOD';
    public $newButton = 'Novo gênero';

    public function sluggable()
    {
        return [
            'slug' => [
            'source' => 'nome',
            ],
        ];
    }

    public $listagem = [
        'Nível' => 'nome',
        'slug',
    ];

    public $formulario = [
        'nome' => [
            'title' => 'Nome do Gênero',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:generovods,nome,$this->id',
        ],
    ];
}
