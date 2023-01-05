<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Modulovod extends Model
{
    use Sluggable;
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Cursos\ModuloPresenter';
    protected $guarded = [
        'aulas',
    ];
    protected $appends = [
    ];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Módulos do Curso VOD';
    public $newButton = 'Novo módulo';

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'titulo',
            ],
        ];
    }

    public $listagem = [
        'titulo',
    ];

    public $formulario = [
        'titulo' => [
            'title' => 'Título do Módulo',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:2',
        ],
        'aulas' => [
            'title' => 'Aulas',
            'type' => 'manyTo',
            'model' => 'Aulavod',
            'table' => 'aulavod_modulovod',
            'show' => 'titulo',
            'width' => 12,
            'validators' => 'required|exists:aulavods,id',
          ],
    ];

    public function curso()
    {
        return $this->belongsTo(Cursovod::class, 'cursovod_id');
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class)->withPivot(['status'])->withTimestamps();
        ;
    }

    public function aulas()
    {
        return $this->belongsToMany(Aulavod::class);
    }
}
