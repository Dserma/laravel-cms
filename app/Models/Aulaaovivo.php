<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;

class Aulaaovivo extends BaseModel
{
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Aovivo\AulaAoVivoPresenter';
    protected $guarded = [];
    protected $appends = [
        'valorFormatado',
    ];
    protected $with = ['categoria', 'professor'];
    public $hasOrder = false;
    public $hasForm = false;
    public $update = false;
    public $delete = false;
    public $title = 'Aulas Ao vivo';

    public $listagem = [
        'profesor' => 'professor.fullName',
        'Categoria' => 'categoria.nome',
        'Duração (em minutos)' => 'duracao',
        'valor' => 'valorFormatado',
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

    public function categoria()
    {
        return $this->belongsTo(Categoriaaovivo::class, 'categoriaaovivo_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professoraovivo::class, 'professoraovivo_id');
    }

    public function pacotes()
    {
        return $this->hasMany(Pacoteaulaaovivo::class);
    }
}
