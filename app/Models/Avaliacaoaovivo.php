<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacaoaovivo extends Model
{
    protected $guarded = [];
    protected $appends = [
        'nomeAula',
        'dataAula',
        'dataAgendamento',
    ];
    public $withAdmin = ['professor', 'aluno', 'agendamento'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = false;
    public $delete = false;
    public $serverSide = false;
    public $title = 'Avaliações Ao vivo';

    public $listagem = [
        'aluno' => 'aluno.fullName',
        'professor' => 'professor.fullName',
        'aula' => 'nomeAula',
        'data' => 'dataAula',

    ];

    public $formulario = [
        'aluno' => [
            'title' => 'Aluno',
            'type' => 'text',
            'width' => 4,
            'relation' => 'fullName',
            'validators' => '',
        ],
        'professor' => [
            'title' => 'Professor',
            'type' => 'text',
            'width' => 4,
            'relation' => 'fullName',
            'validators' => '',
        ],
        'agendamento' => [
            'title' => 'Aula',
            'type' => 'text',
            'width' => 4,
            'relation' => 'aula.categoria.nome',
            'validators' => '',
        ],
        'dataAula' => [
            'title' => 'Data da Aula',
            'type' => 'text',
            'width' => 4,
            'validators' => '',
        ],
        'rate_professor' => [
            'title' => 'Nota que o aluno deu ao professor',
            'type' => 'text',
            'width' => 4,
            'validators' => '',
        ],
        'comentario_aluno' => [
            'title' => 'Comentários do aluno',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'nullable|string|min:10',
        ],
        'comentario_professor' => [
            'title' => 'Comentários do professor',
            'type' => 'textarea',
            'width' => 12,
            'editor' => true,
            'validators' => 'nullable|string|min:10',
        ],
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professoraovivo::class, 'professoraovivo_id');
    }

    public function agendamento()
    {
        return $this->belongsTo(Agendamentoaovivo::class, 'agendamentoaovivo_id');
    }

    public function getNomeAulaAttribute()
    {
        return $this->attributes['nomeAula'] = $this->agendamento->aula->categoria->nome;
    }

    public function getDataAulaAttribute()
    {
        return $this->attributes['dataAula'] = dateBdToApp($this->agendamento->data) . ' - ' . timeWithoutSeconds($this->agendamento->inicio) . ' às ' . timeWithoutSeconds($this->agendamento->fim);
    }

    public function getDataAgendamentoAttribute()
    {
        return $this->attributes['dataAgendamento'] = dateBdToApp($this->agendamento->data);
    }
}
