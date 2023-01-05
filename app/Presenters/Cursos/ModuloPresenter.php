<?php
namespace App\Presenters\Cursos;

use App\Models\Aluno;
use App\Presenters\Presenter;

class ModuloPresenter extends Presenter
{
    public function concluido(Aluno $aluno)
    {
        $aulas = $this->aulas->count();
        $concluidas = $aluno->aulas()->wherePivot('modulovod_id', $this->id)->wherePivot('status', 1)->get()->count();
        $concluido = ($concluidas / $aulas) * 100;

        return number_format($concluido, 2);
    }
}
