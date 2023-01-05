<?php

namespace App\Observers\Sistema\Aovivo;

use App\Models\Agendamentoaovivo;
use App\Notifications\Sistema\Aovivo\AulaNaoExecutada;

class AgendamentoObserver
{
    /**
     * Handle the agendamentoaovivo "created" event.
     *
     * @param  \App\Agendamentoaovivo  $agendamentoaovivo
     * @return void
     */
    public function created(Agendamentoaovivo $agendamentoaovivo)
    {
        //
    }

    /**
     * Handle the agendamentoaovivo "updated" event.
     *
     * @param  \App\Agendamentoaovivo  $agendamentoaovivo
     * @return void
     */
    public function updated(Agendamentoaovivo $agendamentoaovivo)
    {
        if ($agendamentoaovivo->status == 4) {
            $agendamentoaovivo->professor->notify(new AulaNaoExecutada($agendamentoaovivo));
        }
    }

    /**
     * Handle the agendamentoaovivo "deleted" event.
     *
     * @param  \App\Agendamentoaovivo  $agendamentoaovivo
     * @return void
     */
    public function deleted(Agendamentoaovivo $agendamentoaovivo)
    {
        //
    }

    /**
     * Handle the agendamentoaovivo "restored" event.
     *
     * @param  \App\Agendamentoaovivo  $agendamentoaovivo
     * @return void
     */
    public function restored(Agendamentoaovivo $agendamentoaovivo)
    {
        //
    }

    /**
     * Handle the agendamentoaovivo "force deleted" event.
     *
     * @param  \App\Agendamentoaovivo  $agendamentoaovivo
     * @return void
     */
    public function forceDeleted(Agendamentoaovivo $agendamentoaovivo)
    {
        //
    }
}
