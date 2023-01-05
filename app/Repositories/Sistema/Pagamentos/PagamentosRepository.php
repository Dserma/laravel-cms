<?php

namespace App\Repositories\Sistema\Pagamentos;

use Carbon\Carbon;
use App\Models\Aluno;
use App\Models\Cupom;
use App\Models\Empresa;
use App\Models\Pedidoaovivo;
use Illuminate\Support\Facades\Log;
use App\Repositories\Sistema\BaseRepository;
use App\Notifications\PagamentoOkNotification;
use App\Notifications\PagamentoErroNotification;
use App\Http\Requests\Sistema\Pagamento\CupomRequest;
use App\Http\Requests\Sistema\Pagamento\BoletoRequest;
use App\Http\Requests\Sistema\Pagamento\CartaoRequest;

class PagamentosRepository
{
    public static function checkPagamento(Empresa $usuario)
    {
        if ($usuario->status_pedido != 0) {
            return false;
        }

        return true;
    }

    public static function checkCupom(Cupom $cupom, CupomRequest $request)
    {
        if (!$request->cupom) {
            return false;
        }

        if (Carbon::now()->greaterThan($cupom->validade)) {
            return 2;
        }

        $plano = BaseRepository::find('plano', $request->plano_id);

        if ($cupom->plano()->exists()) {
            if ($cupom->plano->id != $plano->id) {
                return 3;
            }
        }

        $valor = $plano->valor;
        $percentual = $cupom->percentual;
        $valorFinal = $valor - (($valor / 100) * $percentual);
        session(['valorPlano' => $valorFinal]);
        session(['cupom' => $cupom->percentual]);
        session(['cupomCode' => $cupom->cupom_wirecard]);

        return true;
    }

    public static function pagaCC(Aluno $aluno, CartaoRequest $request)
    {
        return MoipRepository::criaAssinatura($aluno, $request, 1);
    }

    public static function pagaBoleto(Aluno $aluno, BoletoRequest $request)
    {
        return MoipRepository::criaAssinatura($aluno, $request, 2);
    }

    public static function pagaCCAoVivo(Pedidoaovivo $pedido, CartaoRequest $request)
    {
        return MoipRepository::pedidoAoVivo($pedido, $request, 1);
    }

    public static function pagaBoletoAoVivo(Pedidoaovivo $pedido, BoletoRequest $request)
    {
        return MoipRepository::pedidoAoVivo($pedido, $request, 2);
    }

    public static function atualizaAssinatura(Aluno $aluno, Object $assinatura, Int $status)
    {
        unset($aluno->fullName);
        $aluno->assinatura_gateway_id = $assinatura->code;
        $aluno->status_pedido = $status;
        $aluno->save();
    }

    public static function atualizaValidadeAssinatura(String $assinatura, Int $status)
    {
        $aluno = BaseRepository::get('aluno', ['assinatura_gateway_id' => $assinatura])->first();
        if ($aluno) {
            Log::debug('Atualizando a assinatura: ' . $assinatura);
            if ($status == 3) {
                $aluno->status_pedido = 1;
                $aluno->validade_assinatura = Carbon::now()->addDays($aluno->plano->dias);
                $aluno->notify(new PagamentoOkNotification());
            }
            if ($status == 4 || $status == 5) {
                $aluno->status_pedido = 2;
                $aluno->validade_assinatura = null;
                $aluno->notify(new PagamentoErroNotification());
            }
            $aluno->save();
            $aluno->historico()->create([
                'status' => $status == 3 ? 1 : 2,
            ]);
        }
    }
}
