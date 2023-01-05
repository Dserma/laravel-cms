<?php

namespace App\Observers\Sistema;

use App\Models\Aulaaovivo;
use App\Models\User;
use App\Notifications\Sistema\ModerarProfessor;

class AulaAovivoObserver
{
    /**
     * Handle the aulaaovivo "created" event.
     *
     * @param  \App\Models\Aulaaovivo  $aulaaovivo
     * @return void
     */
    public function created(Aulaaovivo $aulaaovivo)
    {
        if ($aulaaovivo->professor->aulas->count() == 1) {
            $p = $aulaaovivo->professor;
            $p->status = 8;
            $p->save();
            foreach (User::all() as $u) {
                $u->notify(new ModerarProfessor($aulaaovivo->professor));
            }
        }
    }

    /**
     * Handle the aulaaovivo "updated" event.
     *
     * @param  \App\Models\Aulaaovivo  $aulaaovivo
     * @return void
     */
    public function updated(Aulaaovivo $aulaaovivo)
    {
        //
    }

    /**
     * Handle the aulaaovivo "deleted" event.
     *
     * @param  \App\Models\Aulaaovivo  $aulaaovivo
     * @return void
     */
    public function deleted(Aulaaovivo $aulaaovivo)
    {
        //
    }

    /**
     * Handle the aulaaovivo "restored" event.
     *
     * @param  \App\Models\Aulaaovivo  $aulaaovivo
     * @return void
     */
    public function restored(Aulaaovivo $aulaaovivo)
    {
        //
    }

    /**
     * Handle the aulaaovivo "force deleted" event.
     *
     * @param  \App\Models\Aulaaovivo  $aulaaovivo
     * @return void
     */
    public function forceDeleted(Aulaaovivo $aulaaovivo)
    {
        //
    }
}
