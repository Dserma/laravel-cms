<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificadovod extends Model
{
    protected $guarded = [];
    protected $appends = [
        'nomeModulo',
    ];
    protected $with = ['curso', 'modulo'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Certificação VOD';
    public $newButton = 'Novo Certificado';

    public $listagem = [
        'titulo',
        'Curso' => 'curso.titulo',
        'Múdulo' => 'nomeModulo',
    ];

    public $formulario = [
        'titulo' => [
            'title' => 'Título do Certificado',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:certificadovods,titulo,$this->id',
        ],
        'cursovod_id' => [
            'title' => 'Curso',
            'type' => 'belongs',
            'model' => 'Cursovod',
            'show' => 'titulo',
            'width' => 3,
            'validators' => 'required|int|exists:cursovods,id',
        ],
        'modulovod_id' => [
            'title' => 'Módulo',
            'type' => 'belongs',
            'model' => 'Modulovod',
            'show' => 'titulo',
            'width' => 3,
            'validators' => 'nullable|int|exists:modulovods,id',
        ],
        'acertos' => [
            'title' => 'Quantidade de acertos para aprovação',
            'type' => 'number',
            'width' => 3,
            'min' => 1,
            'max' => 99,
            'step' => 1,
            'validators' => 'required|int|min:1',
        ],
    ];

    public function getActions()
    {
        return [
            'perguntas' => [
                'model' => 'Perguntacertificadovod',
                'type' => 'a',
                'color' => 'success',
                'class' => 'btn-pergunta',
                'route' => 'backend.certificadovod.perguntas',
                'title' => 'Perguntas do ',
                'icon' => 'question',
            ],
        ];
    }

    public function curso()
    {
        return $this->belongsTo(Cursovod::class, 'cursovod_id');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulovod::class, 'modulovod_id');
    }

    public function perguntas()
    {
        return $this->hasMany(Perguntacertificadovod::class)->orderBy('order');
    }

    public function getNomeModuloAttribute()
    {
        return $this->attributes['nomeModulo'] = $this->modulo->titulo ?? null;
    }
}
