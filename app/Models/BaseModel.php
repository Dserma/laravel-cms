<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BaseModel extends Model
{
    protected $appends = [
        'imagemTag',
    ];
    public function getImagemAttribute($value)
    {
        if (Storage::exists('/public/storage/' . $value)) {
            return url('/') . '/public/storage/' . $value;
        }

        return  $value;
    }

    public function getImagemTagAttribute()
    {
        return $this->attributes['imagemTag'] = '<img src="' . $this->imagem . '" alt="">';
    }

    public function getValorFormatadoAttribute()
    {
        if ($this->valor != '') {
            return $this->attributes['valorFormatado'] = currencyToApp(currencyToBd($this->valor));
        }

        return null;
    }
}
