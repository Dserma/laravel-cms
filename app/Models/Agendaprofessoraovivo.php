<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendaprofessoraovivo extends Model
{
    public function aula()
    {
        return $this->belongsTo(Aulaaovivo::class, 'aulaaovivo_id');
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class);
    }
}
