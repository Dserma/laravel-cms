<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Nivelvod extends Model
{
    use Sluggable;

    protected $guarded = [];
    protected $appends = [
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Níveis de VOD';
    public $newButton = 'Novo nível';

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
            'title' => 'Nome do Nível',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:nivelvods,nome,$this->id',
        ],
    ];
}
