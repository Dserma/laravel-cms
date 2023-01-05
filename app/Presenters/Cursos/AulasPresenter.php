<?php
namespace App\Presenters\Cursos;

use App\Models\Aluno;
use App\Models\Backingtrakvod;
use App\Models\Modulovod;
use App\Models\Partituravod;
use App\Presenters\Presenter;

class AulasPresenter extends Presenter
{
    public function getPartitura(Partituravod $partitura)
    {
        return url('storage/app/public/backend/aulasvod/') . '/' . $this->id . '/' . $partitura->arquivo;
    }

    public function getPartituraDown(Partituravod $partitura)
    {
        return 'storage/app/public/backend/aulasvod/' . '/' . $this->id . '/' . $partitura->arquivo;
    }

    public function getBack(Backingtrakvod $back)
    {
        return url('storage/app/public/backend/backingtracksvod/') . '/' . $this->id . '/' . $back->arquivo;
    }

    public function getBackDown(Backingtrakvod $back)
    {
        return 'storage/app/public/backend/backingtracksvod/' . '/' . $this->id . '/' . $back->arquivo;
    }

    public function countBts()
    {
        $bts = 0;
        foreach ($this->modulos as $modulo) {
            foreach ($modulo->aulas as $aula) {
                $bts += $aula->backings->count();
            }
        }

        return $bts;
    }

    public function aulas()
    {
        if (count($this->modulos) > 0) {
            $aulas = $this->modulos->first()->aulas()->orderBy('aulavod_modulovod.id')->get();
            if ($aulas) {
                foreach ($aulas as $a) {
                }
            }
        }
    }

    public function concluida(Aluno $aluno, Modulovod $modulo)
    {
        $aula = $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->wherePivot('aulavod_id', $this->id)->first();
        if ($aula) {
            return $aula->pivot->status;
        }

        return 0;
    }

    public function concluidaEm(Aluno $aluno, Modulovod $modulo)
    {
        return $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->wherePivot('aulavod_id', $this->id)->first()->pivot->updated_at->format('d/m/Y h:i:s');
    }

    public function preferida(Aluno $aluno, Modulovod $modulo)
    {
        return $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->wherePivot('aulavod_id', $this->id)->first()->pivot->preferida;
    }
}
