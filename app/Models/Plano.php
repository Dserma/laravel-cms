<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Plano extends BaseModel
{
    use Sluggable;

    protected $guarded = [
    ];
    protected $appends = [
        'valorFormatado',
        'gratuitoTag',
        'exibirTag',
    ];
    public $hasOrder = true;
    public $hasForm = true;
    public $update = true;
    public $title = 'Planos';
    public $newButton = 'Novo Plano';

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nome',
            ],
        ];
    }

    public $listagem = [
        'nome',
        'dias',
        'WireCard' => 'codigo_gateway',
        'Paypal' => 'plano_id_paypal',
        'Exibir no site?' => 'exibirTag',
        'Gratuito' => 'gratuitoTag',
        'Valor' => 'valorFormatado',
        'slug',
    ];

    public $formulario = [
        'gratuito' => [
            'title' => 'Curso Gratuito?',
            'type' => 'radio',
            'width' => 2,
            'src' => 'array',
            'data' => [0 => 'NÃO', 1 => 'SIM'],
            'default' => 0,
            'validators' => 'required|int|min:0|max:1',
        ],
        'exibir' => [
            'title' => 'Exibir no site?',
            'type' => 'radio',
            'width' => 2,
            'src' => 'array',
            'data' => [0 => 'NÃO', 1 => 'SIM'],
            'default' => 0,
            'validators' => 'required|int|min:0|max:1',
        ],
        'codigo_gateway' => [
            'title' => 'Código do Plano no WirdCard',
            'type' => 'text',
            'width' => 4,
            'validators' => 'nullable|string:min:1',
        ],
        'plano_id_paypal' => [
            'title' => 'Código do Plano no Paypal',
            'type' => 'text',
            'width' => 4,
            'validators' => 'nullable|string:min:1',
        ],
        'nome' => [
            'title' => 'Nome do Plano',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string:min:5',
        ],
        'descricao' => [
            'title' => 'Descrição do Plano',
            'type' => 'text',
            'width' => 12,
            'validators' => 'required|string:min:5',
        ],
        'valor' => [
            'title' => 'Valor do Plano',
            'type' => 'text',
            'width' => 3,
            'class' => 'dinheiro-input-mask',
            'validators' => 'required|numeric|min:0',
        ],
        'dias' => [
            'title' => 'Dias de Validade do Plano',
            'type' => 'number',
            'min' => 1,
            'max' => 9999,
            'step' => 1,
            'width' => 3,
            'validators' => 'required|numeric|min:1|max:9999',
        ],
        'economia' => [
            'title' => 'Texto de Economia do Plano',
            'type' => 'text',
            'width' => 12,
            'validators' => 'nullable|string:min:5',
        ],
    ];

    public function getGratuitoTagAttribute()
    {
        switch ($this->gratuito) {
            case 0:
                $tag = '<label for="" class="label label-success">NÃO</label>';

                break;

            default:
                $tag = '<label for="" class="label label-danger">SIM</label>';

                break;
        }

        return $this->attributes['gratuitoTag'] = $tag;
    }

    public function getExibirTagAttribute()
    {
        switch ($this->exibir) {
            case 0:
                $tag = '<label for="" class="label label-danger">NÃO</label>';

                break;

            default:
                $tag = '<label for="" class="label label-success">SIM</label>';

                break;
        }

        return $this->attributes['exibirTag'] = $tag;
    }
}
