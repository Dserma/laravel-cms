<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable;

    protected $guarded = [
      'file_arquivo',
    ];
    protected $appends = [
        'postsCount',
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Tags de Notícias';
    public $newButton = 'Nova tag';

    public function sluggable()
    {
        return [
        'slug' => [
          'source' => 'nome',
        ],
      ];
    }

    public $listagem = [
      'Tag' => 'nome',
      'slug',
      'Notícias' => 'postsCount',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome da Tag',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3|unique:tags,nome,$this->id',
      ],
    ];

    public function posts()
    {
        return $this->belongsToMany(Noticia::class);
    }

    public function getPostsCountAttribute()
    {
        return $this->attributes['postsCount'] = $this->posts()->count();
    }
}
