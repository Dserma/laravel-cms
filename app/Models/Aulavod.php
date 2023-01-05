<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Aulavod extends Model
{
    use Sluggable;
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Cursos\AulasPresenter';
    protected $guarded = [];
    protected $appends = [];
    protected $with = ['categoria', 'professor', 'nivel'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Aula de VOD';
    public $newButton = 'Nova Aula';

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'titulo',
            ],
        ];
    }

    public $searchAdmin = [
        'titulo',
    ];

    public $listagem = [
        'titulo',
        'Categoria' => 'categoria.nome',
        'Nível' => 'nivel.nome',
        'Professor' => 'professor.nome',

    ];

    public $formulario = [
        'titulo' => [
            'title' => 'Título da Aula',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:aulavods,titulo,$this->id',
        ],
        'categoriavod_id' => [
            'title' => 'Categoria',
            'type' => 'belongs',
            'model' => 'Categoriavod',
            'show' => 'nome',
            'width' => 4,
            'validators' => 'required|int|exists:categoriavods,id',
        ],
        'nivelvod_id' => [
            'title' => 'Nível',
            'type' => 'belongs',
            'model' => 'Nivelvod',
            'show' => 'nome',
            'width' => 4,
            'validators' => 'required|int|exists:nivelvods,id',
        ],
        'professorvod_id' => [
            'title' => 'Professor',
            'type' => 'belongs',
            'model' => 'Professorvod',
            'show' => 'nome',
            'width' => 4,
            'validators' => 'required|int|exists:professorvods,id',
        ],
        'tipo_video' => [
            'title' => 'Tipo de Vídeo',
            'type' => 'radio',
            'width' => 2,
            'src' => 'array',
            'data' => [0 => 'AWS', 1 => 'Vimeo'],
            'default' => 0,
            'validators' => 'required|int|min:0|max:1',
        ],
        'video' => [
            'title' => 'URL / Código do Vídeo',
            'type' => 'text',
            'width' => 10,
            'validators' => 'required|string|min:3',
        ],
        'descricao' => [
            'title' => 'Descricão da Aula',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'nullable|string|min:10',
        ],
    ];

    public function getActions()
    {
        return [
            'partituras' => [
                'model' => 'Partituravod',
                'type' => 'a',
                'color' => 'success',
                'class' => 'btn-partitura',
                'route' => 'backend.aulavod.partituras',
                'title' => 'Partituras do ',
                'icon' => 'music',
            ],
            'backingtracks' => [
                'model' => 'backingtrackvod',
                'type' => 'a',
                'color' => 'warning',
                'class' => 'btn-backingtrack',
                'route' => 'backend.aulavod.backingtracks',
                'title' => 'Backingtracks do ',
                'icon' => 'play',
            ],
        ];
    }

    public function categoria()
    {
        return $this->belongsTo(Categoriavod::class, 'categoriavod_id');
    }

    public function nivel()
    {
        return $this->belongsTo(Nivelvod::class, 'nivelvod_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professorvod::class, 'professorvod_id');
    }

    public function partituras()
    {
        return $this->hasMany(Partituravod::class);
    }

    public function backings()
    {
        return $this->hasMany(Backingtrakvod::class);
    }

    public function modulos()
    {
        return $this->belongsToMany(Modulovod::class);
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class)->withPivot(['modulovod_id', 'status'])->withTimestamps();
    }

    public function perguntas()
    {
        return $this->hasMany(Perguntavod::class);
    }
}
