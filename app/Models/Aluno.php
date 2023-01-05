<?php

namespace App\Models;

use App\Traits\Sistema\PresentableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Aluno extends Authenticatable
{
    use Notifiable;
    use PresentableTrait;

    protected $guarded = [
        'email_confirmation',
        'senha_confirmation',
        'fullName',
        'statusTag',
        'formaTag',
        'plano_paypal',
    ];
    protected $hidden = [
        'senha',
    ];
    protected $appends = [
        'fullName',
        'statusTag',
        'formaTag',
        'criado',
    ];
    protected $with = [];
    public $withAdmin = ['plano'];
    public $hasOrder = false;
    public $hasForm = true;
    public $update = true;
    public $serverSide = true;
    public $title = 'Alunos';
    public $newButton = 'Novo Aluno';
    protected $presenter = 'App\Presenters\Alunos\AlunoPresenter';
    public $searchAdmin = [
        'email',
        'nome',
        'sobrenome',
        'created_at',
    ];
    public $listagem = [
        'nome' => [
            'title' => '',
            'value' => '',
            'order' => 'true',
        ],
        'sobrenome' => [
            'title' => '',
            'value' => '',
            'order' => 'true',
        ],
        'email' => [
            'title' => '',
            'value' => '',
            'order' => 'true',
        ],
        'plano' => [
            'title' => 'Plano',
            'value' => 'plano.nome',
            'order' => 'false',
        ],
        'cadastro' => [
            'title' => 'Cadastro',
            'value' => 'criado',
            'order' => 'false',
        ],
        'forma' => [
            'title' => 'Forma de Pagamento',
            'value' => 'formaTag',
            'order' => 'false',
        ],
        'status' => [
            'title' => '',
            'value' => 'statusTag',
            'order' => 'false',
        ],
    ];

    public $formulario = [
        'nome' => [
            'title' => 'Nome do Aluno',
            'type' => 'text',
            'width' => 4,
            'validators' => 'required|string|min:3',
        ],
        'sobrenome' => [
            'title' => 'Sobrenome do Aluno',
            'type' => 'text',
            'width' => 4,
            'validators' => 'nullable|string|min:2',
        ],
        'email' => [
            'title' => 'E-mail do Aluno',
            'type' => 'text',
            'width' => 4,
            'validators' => 'nullable|string|min:3|unique:alunos,email,$this->id|unique:professorvods,email',
        ],
        'telefone' => [
            'title' => 'Telefone do Aluno',
            'type' => 'text',
            'width' => 4,
            'class' => 'telefone-input-mask',
            'validators' => 'nullable|string|min:3',
        ],
        'whatsapp' => [
            'title' => 'Whatsapp do Aluno',
            'type' => 'text',
            'width' => 4,
            'class' => 'telefone-input-mask',
            'validators' => 'nullable|string|min:3',
        ],
        'validade_assinatura' => [
            'title' => 'Validade da Assinatura',
            'type' => 'text',
            'width' => 4,
            'class' => 'data-input-mask',
            'validators' => 'nullable|date_format:d/m/Y',
        ],
        'status_pedido' => [
            'title' => 'Status do Pagamento',
            'type' => 'radio',
            'width' => 4,
            'src' => 'array',
            'data' => [0 => 'Aguardando', 1 => 'Ativo', 2 => 'Cancelado'],
            'default' => 0,
            'validators' => 'nullable|int|min:0|max:2',
        ],
        'forma_pagamento' => [
            'title' => 'Forma de Pagamento',
            'type' => 'radio',
            'width' => 4,
            'src' => 'array',
            'data' => [0 => 'Gratuito', 1 => 'Cartão', 2 => 'Boleto', 3 => 'Depósito'],
            'default' => 1,
            'validators' => 'nullable|int|min:0|max:3',
        ],
        'senha' => [
            'title' => 'Digite uma nova senha para o aluno',
            'type' => 'password',
            'main' => true,
            'token' => 'remember_token',
            'token_size' => 60,
            'width' => 4,
            'validators' => 'nullable|string|min:6',
        ],
        'plano_id' => [
            'title' => 'Plano de Assinatura',
            'type' => 'belongs',
            'model' => 'Plano',
            'show' => 'nome',
            'width' => 4,
            'validators' => 'required|int|exists:planos,id',
        ],
        'pais' => [
            'title' => 'País',
            'type' => 'radio',
            'width' => 4,
            'src' => 'array',
            'data' => [1 => 'Brasil', 2 => 'Outros'],
            'default' => 1,
            'validators' => 'nullable|int|min:0|max:3',
        ],
        'observacoes' => [
            'title' => 'Observações',
            'type' => 'textarea',
            'editor' => true,
            'width' => 12,
            'validators' => 'nullable|string',
        ],
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getActions()
    {
        return [
            'historico' => [
                'model' => 'Historicoaluno',
                'type' => 'a',
                'color' => 'success',
                'class' => 'btn-historico',
                'route' => 'backend.aluno.historico',
                'title' => 'Histórico Financeiro do Aluno ',
                'icon' => 'history',
            ],
        ];
    }

    public function categoria()
    {
        return $this->belongsTo(Categoriavod::class, 'categoriavod_id');
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'plano_id');
    }

    public function cursos()
    {
        return $this->belongsToMany(Cursovod::class)->withPivot(['preferido'])->withTimestamps();
    }

    public function modulos()
    {
        return $this->belongsToMany(Modulovod::class)->withPivot(['cursovod_id', 'status'])->withTimestamps();
    }

    public function aulas()
    {
        return $this->belongsToMany(Aulavod::class)->withPivot(['modulovod_id', 'status', 'preferida'])->withTimestamps();
    }

    public function certificados()
    {
        return $this->belongsToMany(Certificadovod::class)->withPivot(['concluido'])->withTimestamps();
    }

    public function perguntasCertificados()
    {
        return $this->belongsToMany(Perguntacertificadovod::class)->withPivot(['id', 'certificadovod_id', 'resposta'])->withTimestamps();
    }

    public function pedidos()
    {
        return $this->hasMany(Pedidoaovivo::class);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamentoaovivo::class);
    }

    public function historico()
    {
        return $this->hasMany(Historicoaluno::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacaoaovivo::class);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['fullName'] = $this->nome . ' ' . $this->sobrenome;
    }

    public function getStatusTagAttribute()
    {
        switch ($this->status_pedido) {
            case 0:
                $tag = '<label for="" class="label label-warning">Aguardando</label>';

                break;

            case 1:
                $tag = '<label for="" class="label label-success">Ativo</label>';

                break;

            case 2:
                $tag = '<label for="" class="label label-danger">Cancelado</label>';

                break;

            default:
                # code...
                break;
        }

        return $this->attributes['statusTag'] = $tag;
    }

    public function getFormaTagAttribute()
    {
        switch ($this->forma_pagamento) {
            case 0:
                $tag = '<label for="" class="label label-info">Gratuito</label>';

                break;
            case 1:
                $tag = '<label for="" class="label label-success">Cartão de Crédito</label>';

                break;

            case 2:
                $tag = '<label for="" class="label label-primary">Boleto</label>';

                break;

            case 3:
                $tag = '<label for="" class="label label-default">Depósito</label>';

                break;
        }

        return $this->attributes['formaTag'] = $tag;
    }

    public function getCriadoAttribute()
    {
        return $this->attributes['criado'] = dateBdToApp($this->created_at);
    }
}
