<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamentoaovivo extends Model
{
    protected $guarded = [];
    public $withAdmin = ['aluno', 'professor', 'aula'];

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

    public function meeting()
    {
        return $this->hasOne(Meeting::class);
    }

    public function avaliacao()
    {
        return $this->hasOne(Avaliacaoaovivo::class);
    }
}
