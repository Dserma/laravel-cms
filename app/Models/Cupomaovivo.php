<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Cupomaovivo extends Model
{
    use Sluggable;

    protected $appends = [
    ];
    protected $guarded = [
        'rando',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['professor.id', 'professor.nome', 'categoria.nome', 'rando'],
                'separator' => '',
                'unique' => true,
            ],
        ];
    }

    public function professor()
    {
        return $this->belongsTo(Professoraovivo::class, 'professoraovivo_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoriaaovivo::class, 'categoriaaovivo_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aulaaovivo::class, 'aulaaovivo_id');
    }

    public function getRandoAttribute()
    {
        return Str::random(6);
    }
}
