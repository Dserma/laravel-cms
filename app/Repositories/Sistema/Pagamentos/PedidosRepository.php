<?php

namespace App\Repositories\Sistema\Pagamentos;

use App\Models\Aluno;
use App\Models\Cupomaovivo;
use Moip\Resource\Orders;
use Moip\Resource\Payment;
use App\Models\Pedidoaovivo;
use App\Models\Itempedidoaovivo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Sistema\BaseRepository;
use App\Notifications\Aovivo\PagamentoOkNotification;
use App\Repositories\Sistema\Alunos\AlunosRepository;

class PedidosRepository
{
    public static function novo(Aluno $aluno, FormRequest $request, Int $forma)
    {
        $valores = self::getTotais();
        $pedido = new Pedidoaovivo();
        $pedido->aluno_id = $aluno->id;
        $pedido->valor_original = currencyToAppDot($valores['o']);
        $pedido->forma = $forma;
        $pedido->valor = currencyToAppDot($valores['t']);
        if (is_array(session('cupom')) && count(session('cupom')) > 0) {
            $pedido->cupons = implode(',', session('cupom'));
        }
        $pedido->save();
        $pedido->refresh();
        self::criaItensPedido($pedido);
        return $pedido;
    }

    private static function criaItensPedido(Pedidoaovivo $pedido)
    {
        foreach (AlunosRepository::getCart() as $item) {
            $i = new Itempedidoaovivo();
            $i->pedidoaovivo_id = $pedido->id;
            $i->aulaaovivo_id = $item->id;
            if ($item->pacote != '') {
                $pacote = BaseRepository::find('pacoteaulaaovivo', $item->pacote);
                $i->pacoteaulaaovivo_id = $pacote->id;
            }
            if ($pedido->cupons != null) {
                foreach (explode(',', $pedido->cupons) as $c) {
                    $cupom = Cupomaovivo::where('slug', $c)->first();
                    if ($cupom) {
                        if ($cupom->aula()->exists()) {
                            if ($cupom->aula->id == $item->id) {
                                $i->valor_unitario = currencyToAppDot($item->valor - (($item->valor / 100) * $cupom->desconto));
                            }
                        }
                    } else {
                        $i->valor_unitario = $item->valor;
                    }
                }
            } else {
                $i->valor_unitario = $item->valor;
            }

            $i->quantidade = $item->quantidade;
            $i->valor_total = $i->valor_unitario * $item->quantidade;
            $i->save();
        }
    }

    private static function getTotais()
    {
        $array = [
            'o' => 0,
            't' => 0,
        ];
        foreach (AlunosRepository::getCart() as $item) {
            $array['o'] += $item->valor * $item->quantidade;
            $array['t'] += $item->total * $item->quantidade;
        }

        return $array;
    }

    public static function moipCodes(Pedidoaovivo $pedido, Orders $order, Payment $payment)
    {
        $pedido->pedido_gateway = $order->getId();
        $pedido->pagamento_gateway = $payment->getId();
        $pedido->save();
    }

    public static function atualizaPedido(String $payment, String $status)
    {
        $pedido = BaseRepository::get('pedidoaovivo', ['pagamento_gateway' => $payment])->first();
        if ($pedido) {
            Log::debug('Atualizando o pedido: ' . $pedido->id . ' - ' . $status);
            if ($status == 'AUTHORIZED') {
                if ($pedido->status == 0) {
                    $pedido->status = 1;
                    $pedido->save();
                    $pedido->fresh();
                    self::enviaPedidoAprovado($pedido);
                    AlunosRepository::criaAgendamentos($pedido);
                } else {
                    return false;
                }
            }

            if ($status == 'CANCELLED') {
                $pedido->status = 2;
                $pedido->save();
                $pedido->fresh();
                self::enviaPedidoReprovado($pedido);
            }
        }
    }

    public static function enviaPedidoAprovado(Pedidoaovivo $pedido)
    {
        Log::debug('Enviando a aprovação do pedido: ' . $pedido->id);
        $pedido->aluno->notify(new PagamentoOkNotification());
    }

    public static function enviaPedidoReprovado(Pedidoaovivo $pedido)
    {
        Log::debug('Enviando a reprovação do pedido: ' . $pedido->id);
        Mail::send('sistema.emails.pedido-aprovado', [
            'pedido' => $pedido,
        ], function ($mail) use ($pedido) {
            $mail->from(config('app.email'), config('app.name'));
            $mail->to($pedido->aluno->email);
            $mail->subject('Guitarpedia - Pedido aprovado!');
        });
    }
}
