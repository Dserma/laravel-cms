<?php

namespace App\Services\Sistema\Professores;

use Illuminate\Database\Eloquent\Collection;
use Collective\Html\FormFacade as Form;

class ProfessorService
{
    public static function tempoAulas(Collection $aulas)
    {
        $resp = '';
        $i = 0;
        foreach ($aulas as $a) {
            $resp .= view('sistema.aovivo.includes.tempoaula', ['a' => $a, 'i' => $i])->render();
            $i++;
        }

        return $resp;
    }

    public static function comboAulas(Collection $aulas)
    {
        if ($aulas->count() > 0) {
            foreach ($aulas as $aula) {
                $lista[$aula->id] = $aula->categoria->nome . ' - ' . $aula->duracao . ' minutos - ' . currencyToApp($aula->valor);
            }

            return Form::select('aulaaovivo_id', [null => 'Selecione'] + $lista, null, ['class' => 'select2 form-control']);
        }
    }
}
