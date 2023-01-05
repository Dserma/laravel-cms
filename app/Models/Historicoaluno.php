<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historicoaluno extends Model
{
    protected $guarded = [
        'statusTag',
        'formaTag',
        'data',
    ];
    protected $appends = [
        'statusTag',
        'formaTag',
        'data',
        'dataValidade',
        'planoNome',
        'valorFormatado',
    ];
    protected $with = [];
    protected $dates = ['validade'];
    public $withAdmin = ['aluno', 'plano'];
    public $hasOrder = false;
    public $hasForm = false;
    public $update = false;
    public $delete = false;
    public $title = 'Histórico Financeiro';
    public $newButton = 'Novo Histórico';
    public $listagem = [
        'Data do Pagamento' => 'data',
        'Data de Validade' => 'dataValidade',
        'Plano' => 'planoNome',
        'Valor' => 'valorFormatado',
        'Forma de Pagamento' => 'formaTag',
        'Status' => 'statusTag',
    ];

    public function getStatusTagAttribute()
    {
        switch ($this->status) {
            case 1:
                $tag = '<label for="" class="label label-success">Pago</label>';

                break;

            case 2:
                $tag = '<label for="" class="label label-danger">Não Pago</label>';

                break;
            
            default:
                $tag = '<label for="" class="label label-danger">Não Pago</label>';

                break;
        }

        return $this->attributes['statusTag'] = $tag;
    }

    public function getFormaTagAttribute()
    {
        switch ($this->forma) {
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

    public function getDataAttribute()
    {
        return $this->attributes['data'] = $this->created_at->format('d/m/Y H:i:s');
    }

    public function getDataValidadeAttribute()
    {
        if ($this->validade != null) {
            return $this->attributes['dataValidade'] = $this->validade->format('d/m/Y');
        }

        return $this->attributes['dataValidade'] = '';
    }

    public function getPlanoNomeAttribute()
    {
        if ($this->plano_id != null) {
            return $this->attributes['planoNome'] = $this->plano->nome;
        }

        return $this->attributes['planoNome'] = '';
    }

    public function getValorFOrmatadoAttribute()
    {
        if ($this->valor != null) {
            return $this->attributes['valorFormatado'] = currencyToApp($this->valor);
        }

        return $this->attributes['valorFormatado'] = '';
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'plano_id');
    }
}
