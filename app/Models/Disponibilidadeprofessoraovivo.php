<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilidadeprofessoraovivo extends Model
{
    protected $guarded = [];
    public $hasOrder = true;

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }
}
