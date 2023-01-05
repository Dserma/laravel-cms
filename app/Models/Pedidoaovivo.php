<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidoaovivo extends Model
{
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function items()
    {
        return $this->hasMany(Itempedidoaovivo::class);
    }
}
