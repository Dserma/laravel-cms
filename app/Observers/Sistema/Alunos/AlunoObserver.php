<?php

namespace App\Observers\Sistema\Alunos;

use App\Models\Aluno;
use App\Notifications\CadastroNotification;
use App\Repositories\Sistema\Alunos\AlunosRepository;
use App\Http\Requests\Sistema\Login\EsqueciSenhaRequest;

class AlunoObserver
{
    /**
     * Handle the aluno "created" event.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return void
     */
    public function created(Aluno $aluno)
    {
        $aluno->notify(new CadastroNotification());
        if ($aluno->wasChanged('senha') & $aluno->senha != null) {
            $request = new EsqueciSenhaRequest();
            $request['email'] = $aluno->email;
            $request['senha'] = $aluno->senha;
            AlunosRepository::recuperarSenha($request);
        }
    }

    /**
     * Handle the aluno "updated" event.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return void
     */
    public function updated(Aluno $aluno)
    {
        if ($aluno->wasChanged('senha') & $aluno->senha != null) {
            // $request = new EsqueciSenhaRequest();
            // $request['email'] = $aluno->email;
            // $request['senha'] = $aluno->senha;
            // AlunosRepository::recuperarSenha($request);
        }
        if ($aluno->wasChanged('validade_assinatura')) {
            AlunosRepository::adicionaHistorico($aluno);
        }
    }

    /**
     * Handle the aluno "deleted" event.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return void
     */
    public function deleted(Aluno $aluno)
    {
        //
    }

    /**
     * Handle the aluno "restored" event.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return void
     */
    public function restored(Aluno $aluno)
    {
        //
    }

    /**
     * Handle the aluno "force deleted" event.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return void
     */
    public function forceDeleted(Aluno $aluno)
    {
        //
    }
}
