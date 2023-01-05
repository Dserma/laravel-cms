<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class Professorvod extends BaseModel
{
    use Sluggable;
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Professores\ProfessorPresenter';
    protected $guarded = [];
    protected $appends = [
        'imagemTag',
    ];
    protected $with = ['categoria'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Professores de VOD';
    public $newButton = 'Novo professor';

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nome',
            ],
        ];
    }

    public $listagem = [
        'Imagem' => 'imagemTag',
        'nome',
        'Categoria' => 'categoria.nome',

    ];

    public $formulario = [
        'categoriavod_id' => [
            'title' => 'Categoria',
            'type' => 'belongs',
            'model' => 'Categoriavod',
            'show' => 'nome',
            'width' => 4,
            'validators' => 'required|int|exists:categoriavods,id',
        ],
        'nome' => [
            'title' => 'Nome do Professor',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:professorvods,nome,$this->id',
        ],
        'imagem' => [
            'title' => 'Imagem do Professor',
            'type' => 'image',
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'sobre' => [
            'title' => 'Sobre o Professor',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'nullable|string|min:10',
        ],
        'apresentacao' => [
            'title' => 'Apresentacao o Professor',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'nullable|string|min:10',
        ],
        'video' => [
            'title' => 'Video do Professor',
            'type' => 'url',
            'width' => 12,
            'validators' => 'nullable|url|min:3',
        ],
        'facebook' => [
            'title' => 'Facebook',
            'type' => 'url',
            'width' => 3,
            'validators' => 'nullable|url|min:3',
        ],
        'instagram' => [
            'title' => 'Instagram',
            'type' => 'url',
            'width' => 3,
            'validators' => 'nullable|url|min:3',
        ],
        'twitter' => [
            'title' => 'Twitter',
            'type' => 'url',
            'width' => 3,
            'validators' => 'nullable|url|min:3',
        ],
        'youtube' => [
            'title' => 'Youtube',
            'type' => 'url',
            'width' => 3,
            'validators' => 'nullable|url|min:3',
        ],
        'site' => [
            'title' => 'Site',
            'type' => 'url',
            'width' => 6,
            'validators' => 'nullable|url|min:3',
        ],
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoriavod::class, 'categoriavod_id');
    }

    public function cursos()
    {
        return $this->hasMany(Cursovod::class);
    }
}
