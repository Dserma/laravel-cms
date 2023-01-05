<?php

namespace App\Http\Controllers\Backend\Alunos;

use App\Http\Controllers\Backend\BackController;
use App\Models\Aluno;

class AlunoController extends BackController
{
    public function historico(Aluno $aluno)
    {
        return view('backend.alunos.historico', [
          'aluno' => $aluno,
        ]);
    }
}
