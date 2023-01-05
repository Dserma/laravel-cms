<?php
namespace App\Presenters\Alunos;

use Carbon\Carbon;
use App\Models\Cursovod;
use App\Presenters\Presenter;
use App\Repositories\Sistema\BaseRepository;

class AlunoPresenter extends Presenter
{
    public function estado(Int $id = null)
    {
        if ($id) {
            return BaseRepository::find('estado', $id)->letter;
        }
    }

    public function cidade(Int $id = null)
    {
        if ($id) {
            return BaseRepository::find('cidade', $id)->iso;
        }
    }

    public function checkAssinatura(Cursovod $curso)
    {
        if (!$this->validade_assinatura && $curso->gratuito == 0) {
            return false;
        }

        if ($this->validade_assinatura . ' 23:59:59' < Carbon::now() && $curso->gratuito == 0) {
            return false;
        }

        if (($this->plano->gratuito == 1 && $this->plano->exibir == 1) && $curso->gratuito == 0) {
            return false;
        }

        if ($this->plano->gratuito == 1 && $this->plano->exibir == 0) {
            return true;
        }

        return true;
    }

    public function checkAssinaturaGlobal()
    {
        if ($this->plano->gratuito != 1) {
            if (!$this->validade_assinatura) {
                return false;
            }

            if ($this->validade_assinatura . ' 23:59:59' < Carbon::now()) {
                return false;
            }

            if ($this->plano->gratuito == 1) {
                return false;
            }
        }

        return true;
    }
}
