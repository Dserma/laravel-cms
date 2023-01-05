<?php
namespace App\Presenters\Cursos;

use App\Models\Aluno;
use App\Models\Aulavod;
use App\Models\Modulovod;
use App\Presenters\Presenter;
use App\Repositories\Sistema\BaseRepository;

class CursoPresenter extends Presenter
{
    public function countAulas()
    {
        $aulas = 0;
        foreach ($this->modulos as $modulo) {
            $aulas += $modulo->aulas->count();
        }

        return $aulas;
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
        // pre($this);
        if (count($this->modulos) > 0) {
            $aulas = $this->modulos->first()->aulas()->orderBy('aulavod_modulovod.id')->get();
            if ($aulas) {
                foreach ($aulas as $a) {
                    // echo $a->id;
                }
            }
        }
        // exit();
        // return $arr;
    }

    public function continuar($aluno)
    {
        $moduloAtual = $aluno->modulos()->wherePivot('cursovod_id', $this->id)->orderBy('pivot_updated_at', 'DESC')->first();
        $aulaAtual = $aluno->aulas()->wherePivot('modulovod_id', $moduloAtual->id)->orderBy('pivot_updated_at', 'DESC')->first();
        $data['modulo'] = $moduloAtual->slug;
        $data['aula'] = $aulaAtual->slug;

        return $data;
    }

    public function getModuloBySlug($slug)
    {
        return BaseRepository::get('modulovod', ['slug' => $slug])->first();
    }

    public function getAulaBySlug($slug)
    {
        return BaseRepository::get('aulavod', ['slug' => $slug])->first();
    }

    public function aulaConcluida(Aluno $aluno, Modulovod $modulo, Aulavod $aula)
    {
        return $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->wherePivot('aulavod_id', $aula->id)->first()->pivot->status;
    }

    public function concluido(Aluno $aluno)
    {
        $aulas = 0;
        $concluidos = 0;
        foreach ($this->modulos as $m) {
            $aulas += $m->aulas->count();
            $concluidos += $aluno->aulas()->wherePivot('modulovod_id', $m->id)->wherePivot('status', 1)->get()->count();
        }

        $concluido = ($concluidos / $aulas) * 100;

        return number_format($concluido, 2);
    }

    public function preferido(Aluno $aluno)
    {
        return $aluno->cursos()->wherePivot('cursovod_id', $this->id)->first()->pivot->preferido;
    }
}
