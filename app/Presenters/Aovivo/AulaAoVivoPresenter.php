<?php
namespace App\Presenters\Aovivo;

use App\Presenters\Presenter;
use App\Repositories\Sistema\BaseRepository;

class AulaAoVivoPresenter extends Presenter
{
    public function nomeAula()
    {
        return $this->professor->fullName . ' - ' . $this->categoria->nome . ' - ' . $this->duracao . ' minutos';
    }

    public function getValorPacote()
    {
        $pacote = BaseRepository::find('pacoteaulaaovivo', $this->pacote);
        $qtd = $pacote->quantidade;

        return $this->valor * $qtd;
    }
}
