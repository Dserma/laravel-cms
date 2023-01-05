<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Categoriapost extends Model
{
    use Sluggable;

    protected $guarded = [];
    protected $appends = [
        'postsCount',
    ];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Categorias de Blog';
    public $newButton = 'Nova categoria';

    public function sluggable()
    {
        return [
        'slug' => [
          'source' => 'nome',
        ],
      ];
    }

    public $listagem = [
      'Categoria' => 'nome',
      'slug',
      'Posts' => 'postsCount',
    ];

    public $formulario = [
      'nome' => [
        'title' => 'Nome da Categoria',
        'type' => 'text',
        'width' => 12,
        'validators' => 'required|string|min:3|unique:categoriaposts,nome,$this->id',
      ],
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getPostsCountAttribute()
    {
        return $this->attributes['postsCount'] = $this->posts()->count();
    }
}
