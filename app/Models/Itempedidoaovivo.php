<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itempedidoaovivo extends Model
{
    public function aula()
    {
        return $this->belongsTo(Aulaaovivo::class, 'aulaaovivo_id');
    }

    public function pacote()
    {
        return $this->belongsTo(Pacoteaulaaovivo::class, 'pacoteaulaaovivo_id');
    }
}
