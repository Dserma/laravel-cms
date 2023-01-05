<?php

namespace App\Repositories\Sistema\Noticias;

use App\Models\Categorianoticia;
use App\Models\Noticia;
use App\Repositories\Sistema\BaseRepository;

class NoticiasRepository
{
    public static function getDestaques(array $destaques)
    {
        foreach ($destaques as $destaque) {
            $array[] = BaseRepository::find('noticia', $destaque);
        }

        return collect($array);
    }

    public static function noticias(array $destaques, Categorianoticia $categoria = null)
    {
        return Noticia::whereNotIn('id', $destaques)
            ->when($categoria != null, function ($q) use ($categoria) {
                return $q->where('categorianoticia_id', $categoria->id);
            })
            ->paginate(3);
    }
}
