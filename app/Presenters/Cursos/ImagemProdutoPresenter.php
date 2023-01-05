<?php
namespace App\Presenters\Produtos;

use App\Models\Produto;
use App\Presenters\Presenter;

class ImagemProdutoPresenter extends Presenter
{
    public function img(Produto $produto)
    {
        return url('storage/app/public/backend/produtos/') . '/' . $produto->id . '/' . $this->imagem;
    }
}
