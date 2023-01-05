<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perguntacertificadovod extends Model
{
    protected $guarded = [
        'certificado',
    ];
    protected $appends = [
        'respCorreta',
    ];
    protected $with = ['certificado'];
    public $hasOrder = true;
    public $orderKey = 'certificadovod_id';
    public $hasForm = true;
    public $update = true;
    public $title = 'Perguntas do Certificado VOD';
    public $newButton = 'Nova Pergunta';

    public $listagem = [
        'pergunta',
        'Resposta Correta' => 'correta',
    ];

    public $formulario = [
        'pergunta' => [
            'title' => 'Pergunta',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'resposta_1' => [
            'title' => 'Resposta 1',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'resposta_2' => [
            'title' => 'Resposta 2',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'required|string|min:3',
        ],
        'resposta_3' => [
            'title' => 'Resposta 3',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:3',
        ],
        'resposta_4' => [
            'title' => 'Resposta 4',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:3',
        ],
        'resposta_5' => [
            'title' => 'Resposta 5',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string|min:3',
        ],
        'correta' => [
            'title' => 'Resposta correta',
            'type' => 'radio',
            'width' => 6,
            'src' => 'array',
            'data' => [1 => 'Resposta 1', 2 => 'Resposta 2', 3 => 'Resposta 3', 4 => 'Resposta 4', 5 => 'Resposta 5'],
            'default' => 1,
            'validators' => 'required|int|min:1|max:5',
        ],
    ];

    public function certificado()
    {
        return $this->belongsTo(Certificadovod::class, 'certificadovod_id');
    }

    public function getRespCorretaAttribute()
    {
        return $this->attributes['respCorreta'] = $this->modulo->titulo ?? null;
    }
}
