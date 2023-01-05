<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;

class Imagemproduto extends BaseModel
{
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Produtos\ImagemProdutoPresenter';
}
