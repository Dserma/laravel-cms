<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backingtrakvod extends Model
{
    public function aula()
    {
        return $this->belongsTo(Aulavod::class, 'aulavod_id');
    }
}
