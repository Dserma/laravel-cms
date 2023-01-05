<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sistema\PresentableTrait;

class Imagemsobrenos extends Model
{
    use PresentableTrait;

    protected $presenter = 'App\Presenters\Sistema\ImagemSobreNosPresenter';
    protected $guarded = [];

    public $title = 'Sobre Nós - Imagens';
    public $type = 'gallery';
    public $field = 'imagem';
}
