<?php

namespace App\Observers\Sistema\Perguntas;

use App\Models\Perguntavod;
use App\Notifications\Sistema\Alunos\RespostaNotification;

class PerguntaObserver
{
    /**
     * Handle the perguntavod "created" event.
     *
     * @param  \App\Perguntavod  $perguntavod
     * @return void
     */
    public function created(Perguntavod $perguntavod)
    {
        //
    }

    /**
     * Handle the perguntavod "updated" event.
     *
     * @param  \App\Perguntavod  $perguntavod
     * @return void
     */
    public function updated(Perguntavod $pergunta)
    {
        if ($pergunta->status == 1) {
            $pergunta->aluno->notify(new RespostaNotification($pergunta));
        }
    }

    /**
     * Handle the perguntavod "deleted" event.
     *
     * @param  \App\Perguntavod  $perguntavod
     * @return void
     */
    public function deleted(Perguntavod $perguntavod)
    {
        //
    }

    /**
     * Handle the perguntavod "restored" event.
     *
     * @param  \App\Perguntavod  $perguntavod
     * @return void
     */
    public function restored(Perguntavod $perguntavod)
    {
        //
    }

    /**
     * Handle the perguntavod "force deleted" event.
     *
     * @param  \App\Perguntavod  $perguntavod
     * @return void
     */
    public function forceDeleted(Perguntavod $perguntavod)
    {
        //
    }
}
