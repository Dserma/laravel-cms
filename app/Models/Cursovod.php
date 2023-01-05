<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\Sistema\PresentableTrait;

class Cursovod extends BaseModel
{
    use Sluggable;
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Cursos\CursoPresenter';
    protected $guarded = [];
    protected $appends = [
        'imagemTag',
        'gratuitoTag',
    ];
    protected $with = ['categoria', 'professor', 'nivel', 'genero'];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Curso VOD';
    public $newButton = 'Novo Curso';
    public $searchAdmin = [
        'titulo',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'titulo',
            ],
        ];
    }

    public $listagem = [
        'Imagem' => 'imagemTag',
        'titulo',
        'Categoria' => 'categoria.nome',
        'Nível' => 'nivel.nome',
        'Professor' => 'professor.nome',
        'Gratuito' => 'gratuitoTag',

    ];

    public $formulario = [
        'gratuito' => [
            'title' => 'Curso Gratuito?',
            'type' => 'radio',
            'width' => 2,
            'src' => 'array',
            'data' => [0 => 'NÃO', 1 => 'SIM'],
            'default' => 0,
            'validators' => 'required|int|min:0|max:1',
        ],
        'tempo' => [
            'title' => 'Duração do Curso ( em horas )',
            'type' => 'text',
            'width' => 3,
            'validators' => 'required|string|min:1',
        ],
        'titulo' => [
            'title' => 'Título do Curso',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:aulavods,titulo,$this->id',
        ],
        'video_apresentacao' => [
            'title' => 'Vídeo de Apresentação do Curso',
            'type' => 'video',
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'categoriavod_id' => [
            'title' => 'Categoria',
            'type' => 'belongs',
            'model' => 'Categoriavod',
            'show' => 'nome',
            'width' => 3,
            'validators' => 'required|int|exists:categoriavods,id',
        ],
        'generovod_id' => [
            'title' => 'Gênero',
            'type' => 'belongs',
            'model' => 'Generovod',
            'show' => 'nome',
            'width' => 3,
            'validators' => 'required|int|exists:generovods,id',
        ],
        'nivelvod_id' => [
            'title' => 'Nível',
            'type' => 'belongs',
            'model' => 'Nivelvod',
            'show' => 'nome',
            'width' => 3,
            'validators' => 'required|int|exists:nivelvods,id',
        ],
        'professorvod_id' => [
            'title' => 'Professor',
            'type' => 'belongs',
            'model' => 'Professorvod',
            'show' => 'nome',
            'width' => 3,
            'validators' => 'required|int|exists:professorvods,id',
        ],
        'imagem' => [
            'title' => 'Imagem do Curso',
            'type' => 'image',
            'width' => 12,
            'validators' => 'required|string|min:10',
        ],
        'resumo' => [
            'title' => 'Resumo do Curso',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'required|string|min:10',
        ],
        'descricao' => [
            'title' => 'Descrição do Curso',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'required|string|min:10',
        ],
        'aprender' => [
            'title' => 'O que você vai aprender neste curso ( Um item por linha )',
            'type' => 'textarea',
            'width' => 6,
            'limit' => 0,
            'editor' => false,
            'validators' => 'required|string|min:10',
        ],
        'requisitos' => [
            'title' => 'Pré Requisitos( Um item por linha )',
            'type' => 'textarea',
            'width' => 6,
            'limit' => 0,
            'editor' => false,
            'validators' => 'required|string|min:10',
        ],
        'keywords' => [
            'title' => 'Palavras Chave ( SEO )',
            'type' => 'textarea',
            'width' => 6,
            'limit' => 0,
            'editor' => false,
            'validators' => 'required|string|min:10',
        ],
    ];

    public function getActions()
    {
        return [
            'modulos' => [
                'model' => 'Modulovod',
                'type' => 'a',
                'color' => 'success',
                'class' => 'btn-modulo',
                'route' => 'backend.cursosvod.modulos',
                'title' => 'Módulos do ',
                'icon' => 'puzzle-piece',
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

    public function genero()
    {
        return $this->belongsTo(Generovod::class, 'generovod_id');
    }

    public function modulos()
    {
        return $this->hasMany(Modulovod::class)->orderBy('order');
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class);
    }

    public function perguntas()
    {
        return $this->hasMany(Perguntavod::class);
    }

    public function getGratuitoTagAttribute()
    {
        switch ($this->gratuito) {
            case 0:
                $tag = '<label for="" class="label label-success">NÃO</label>';

                break;

            default:
                $tag = '<label for="" class="label label-danger">SIM</label>';

                break;
        }

        return $this->attributes['gratuitoTag'] = $tag;
    }
}
