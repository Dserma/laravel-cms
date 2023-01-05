<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semlicenca extends Model
{
    protected $guarded = [];
    protected $appends = [
        'nomeAula',
        'dataHora',
    ];
    public $withAdmin = ['aluno', 'professor', 'aula'];
    public $hasOrder = false;
    public $hasForm = false;
    public $update = false;
    public $delete = false;
    public $title = 'Relatório de Falta de Licenças do Zoom';

    public $listagem = [
        'Aluno' => 'aluno.fullName',
        'Professor' => 'professor.fullName',
        'Aula' => 'nomeAula',
        'Data' => 'dataHora',
    ];

    public $formulario = [
        'nome' => [
            'title' => 'Nome da Categoria',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:3|unique:categoriaaovivos,nome,$this->id',
        ],
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professoraovivo::class, 'professoraovivo_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aulaaovivo::class, 'aulaaovivo_id');
    }

    public function getNomeAulaAttribute()
    {
        return $this->attributes['nomeAula'] = $this->aula->categoria->nome . ' - ' . $this->aula->duracao . ' minutos';
    }

    public function getDataHoraAttribute()
    {
        return $this->attributes['dataHora'] = dateBdToApp($this->data) . ' às ' . $this->hora;
    }
}
