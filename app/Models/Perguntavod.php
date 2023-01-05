<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perguntavod extends Model
{
    protected $guarded = [];
    protected $appends = [
        'statusTag',
    ];
    protected $with = ['aluno', 'aula'];
    public $hasOrder = false;
    public $serverSide = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Perguntas VOD';

    public $listagem = [
        'Autor' => 'aluno.nome',
        'Aula' => 'aula.titulo',
        'Status' => 'statusTag',
    ];

    public $formulario = [
        'pergunta' => [
            'title' => 'Pergunta:',
            'type' => 'textarea',
            'width' => 12,
            'editor' => false,
            'limit' => '999999',
            'validators' => 'required|string|min:10',
        ],
        'resposta' => [
            'title' => 'Resposta:',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'required|string|min:10',
        ],
        'status' => [
            'title' => 'Responder e Exibir?',
            'type' => 'radio',
            'width' => 2,
            'src' => 'array',
            'data' => [0 => 'NÃO', 1 => 'SIM'],
            'default' => 0,
            'validators' => 'required|int|min:0|max:1',
        ],
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    public function curso()
    {
        return $this->belongsTo(Cursovod::class, 'cursovod_id');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulovod::class, 'modulovod_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aulavod::class, 'aulavod_id');
    }

    public function getStatusTagAttribute()
    {
        switch ($this->status) {
            case 0:
                $tag = '<label class="label label-danger">Não Respondida</label>';

                break;

            default:
                $tag = '<label class="label label-success">Respondida</label>';

                break;
        }

        return $this->attributes['statusTag'] = $tag;
    }
}
