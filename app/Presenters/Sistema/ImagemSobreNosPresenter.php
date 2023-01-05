<?php
namespace App\Presenters\Sistema;

use App\Presenters\Presenter;

class ImagemSobreNosPresenter extends Presenter
{
    public function img()
    {
        return url('storage/app/public/backend/') . '/' . $this->entity->imagem;
    }
}
