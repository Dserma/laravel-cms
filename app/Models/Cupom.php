<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Cupom extends Model
{
    use Sluggable;

    protected $guarded = [];
    protected $appends = [];
    protected $with = ['plano'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $title = 'Cupons de Desconto';
    public $newButton = 'Novo Cupom';

    public $listagem = [
        'nome',
        'Código' => 'slug',
        'Código Wirecard' => 'cupom_wirecard',
        'Valor do desconto (%)' => 'percentual',
        'Validade do Cupom' => 'validade',
        'Plano' => 'plano.nome',
    ];

    public $formulario = [
        'plano_id' => [
          'title' => 'Plano Vinculado',
          'type' => 'belongs',
          'model' => 'Plano',
          'show' => 'nome',
          'width' => 4,
          'validators' => 'nullable|int|exists:planos,id',
        ],
        'cupom_wirecard' => [
          'title' => 'Código do Cupom no Wirecard',
          'type' => 'text',
          'width' => 4,
          'validators' => 'required|string|min:2',
        ],
        'nome' => [
          'title' => 'Nome do Cupom',
          'type' => 'text',
          'width' => 12,
          'validators' => 'required|string|min:2',
        ],
        'percentual' => [
          'title' => 'Valor do desconto ( % )',
          'type' => 'text',
          'width' => 6,
          'class' => 'dinheiro-input-mask',
          'validators' => 'required|numeric|min:0',
        ],
        'validade' => [
          'title' => 'Data de Validade',
          'type' => 'text',
          'width' => 6,
          'class' => 'data-input-mask',
          'validators' => 'required|date_format:d/m/Y',
        ],
    ];

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'plano_id')->withDefault(['nome' => null]);
    }

    public function sluggable()
    {
        return [
            'slug' => [
            'source' => ['nome'],
            ],
        ];
    }
}
