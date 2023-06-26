<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [];
    public $listagem = [
        'nome',
    ];
    public $newButton = 'Nova Categoria';
    public $title = 'Categorias';
    public $hasForm = true;
    public $update = true;
    public $formulario = [
        'nome' => [
            'title' => 'Nome da Categoria',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string|min:2|unique:categorias,nome,$this->id',
        ],
    ];
}
