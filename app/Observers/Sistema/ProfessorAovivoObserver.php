<?php

namespace App\Observers\Sistema;

use App\Models\User;
use App\Models\Professoraovivo;
use App\Notifications\Sistema\ProfessorAlterado;
use App\Notifications\Sistema\ProfessorBloqueado;

class ProfessorAovivoObserver
{
    /**
     * Handle the professoraovivo "created" event.
     *
     * @param  \App\Professoraovivo  $professoraovivo
     * @return void
     */
    public function created(Professoraovivo $professoraovivo)
    {
        //
    }

    /**
     * Handle the professoraovivo "updated" event.
     *
     * @param  \App\Professoraovivo  $professoraovivo
     * @return void
     */
    public function updated(Professoraovivo $professoraovivo)
    {
        if ($professoraovivo->status == 2) {
            $professoraovivo->notify(new ProfessorBloqueado());
        }
        if ($professoraovivo->status == 1) {
            $attrs = [
                'nome',
                'sobrenome',
                'imagem',
                'video',
                'apresentacao',
                'destaque',
                'sobre',
                'metodo',
                'credenciais',
            ];
            if ($professoraovivo->wasChanged($attrs)) {
                foreach (User::all() as $u) {
                    $u->notify(new ProfessorAlterado($professoraovivo));
                }
            }
        }
    }

    /**
     * Handle the professoraovivo "deleted" event.
     *
     * @param  \App\Professoraovivo  $professoraovivo
     * @return void
     */
    public function deleted(Professoraovivo $professoraovivo)
    {
        //
    }

    /**
     * Handle the professoraovivo "restored" event.
     *
     * @param  \App\Professoraovivo  $professoraovivo
     * @return void
     */
    public function restored(Professoraovivo $professoraovivo)
    {
        //
    }

    /**
     * Handle the professoraovivo "force deleted" event.
     *
     * @param  \App\Professoraovivo  $professoraovivo
     * @return void
     */
    public function forceDeleted(Professoraovivo $professoraovivo)
    {
        //
    }
}
