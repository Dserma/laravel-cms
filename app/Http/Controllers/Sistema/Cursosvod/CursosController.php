<?php

namespace App\Http\Controllers\Sistema\Cursosvod;

use App\Models\Plano;
use App\Models\Cursovod;
use App\Models\Categoriavod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\Sistema\SistemaService;
use App\Repositories\Sistema\BaseRepository;
use App\Notifications\AssinaturaNotification;
use App\Http\Requests\Sistema\Pagamento\CupomRequest;
use App\Http\Requests\Sistema\Pagamento\BoletoRequest;
use App\Http\Requests\Sistema\Pagamento\CartaoRequest;
use App\Models\Cupom;
use App\Repositories\Sistema\Alunos\AlunosRepository;
use App\Repositories\Sistema\Pagamentos\PaypalRepository;
use App\Repositories\Sistema\Pagamentos\PagamentosRepository;

class CursosController extends Controller
{
    public function index(Categoriavod $categoria = null)
    {
        return view('sistema.cursosvod.index', [
            'categorias' => BaseRepository::toSelectOther(BaseRepository::all('categoriavod'), 'nome', 'slug'),
            'generos' => BaseRepository::toSelectOther(BaseRepository::all('generovod'), 'nome', 'slug'),
            'niveis' => BaseRepository::toSelectOther(BaseRepository::all('nivelvod'), 'nome', 'slug'),
            'professores' => BaseRepository::toSelectOther(BaseRepository::all('professorvod'), 'nome', 'slug'),
            'categoria' => $categoria,
            'cursos' => $categoria == null ? BaseRepository::all('cursovod') : $categoria->cursos,
        ]);
    }

    public function curso(Categoriavod $categoria, Cursovod $curso)
    {
        return view('sistema.cursosvod.single', [
            'curso' => $curso,
            'planos' => BaseRepository::toSelectOther(BaseRepository::all('plano'), 'nome', 'slug'),
            'semelhantes' => BaseRepository::get('cursovod', ['categoriavod_id' => $curso->categoriavod_id, 'gratuito' => 0]),
        ]);
    }

    public function assinatura(Plano $plano = null)
    {
        return view('sistema.cursosvod.cart.index', [
            'planos' => BaseRepository::order('plano'),
            'planoE' => $plano,
        ]);
    }

    public function pagamento()
    {
        $plano = $this->usuario->plano;

        if (!Session('valorPlano')) {
            session(['valorPlano' => (float) $plano->valor]);
        }

        if ($this->usuario->pais == 2) {
            // $paypal = PaypalRepository::criaAssinatura($this->usuario);
        }

        return view('sistema.cursosvod.cart.pagamento', [
            'aluno' => $this->usuario,
            'plano' => $plano,
            'paypal' => $paypal ?? null,
        ]);
    }

    public function pagamentoConfirmacao(Request $request)
    {
        return view('sistema.confirmacao-pagamento', [
            'conteudo' => BaseRepository::find('confirmacaopagamento', 1),
            'request' => $request,
            'cupom' => Cupom::where('cupom_wirecard', Session('cupomCode'))->first(),
        ]);
    }

    public function cupom(CupomRequest $request)
    {
        $cupom = BaseRepository::get('cupom', ['slug' => $request->cupom])->first();
        $resposta = PagamentosRepository::checkCupom($cupom, $request);
        if ($resposta === 2) {
            return SistemaService::jsonR(200, 0, 'Este cupom perdeu a sua validade!', 0, 4);
        }
        if ($resposta === 3) {
            return SistemaService::jsonR(200, 0, 'Este cupom não pode ser utilizado neste plano!', 0, 4);
        }

        return SistemaService::jsonR(200, 1, 'Cupom aplicado com sucesso!', 0, 2);
    }

    public function removeCupom()
    {
        if (!Session('valorPlano') || Session('valorPlano') == (float) $this->usuario->plano->valor) {
            return SistemaService::jsonR(200, 0, '', 0, 2);
        }
        Session(['valorPlano' => (float) $this->usuario->plano->valor]);
        Session::forget('cupomCode');
        Session::save();

        return SistemaService::jsonR(200, 1, 'Cupom removido com sucesso!', 0, 2);
    }

    public function pagamentoCartao(CartaoRequest $request)
    {
        if ($this->usuario->assinatura_gateway_id != null) {
            AlunosRepository::cancelaAssinaturaParaNova($this->usuario);
        }
        $pagamento = PagamentosRepository::pagaCC($this->usuario, $request);
        if (count($pagamento->errors) == 0) {
            PagamentosRepository::atualizaAssinatura($this->usuario, $pagamento, 0);
            $this->usuario->forma_pagamento = 1;
            $this->usuario->save();
            $this->usuario->notify(new AssinaturaNotification());

            return SistemaService::jsonR(200, 1, 'Pagamento de assinatura enviado com sucesso, obrigado!', route('sistema.sua-conta.confirmacao'));
        }

        return SistemaService::jsonR(200, 0, 'Ocorreu um problema com seu pagamento! Tente novamente <br><b>Erro:' . $pagamento->errors[0]->description . '</b>', 0, 2);
    }

    public function pagamentoBoleto(BoletoRequest $request)
    {
        if ($this->usuario->assinatura_gateway_id != null) {
            AlunosRepository::cancelaAssinaturaParaNova($this->usuario);
        }
        $pagamento = PagamentosRepository::pagaBoleto($this->usuario, $request);
        if (count($pagamento->errors) == 0) {
            session(['urlBoleto' => $pagamento->_links->boleto->redirect_href]);
            PagamentosRepository::atualizaAssinatura($this->usuario, $pagamento, 0);
            $this->usuario->forma_pagamento = 2;
            $this->usuario->save();
            $this->usuario->notify(new AssinaturaNotification());

            return SistemaService::jsonR(200, 1, 'Pagamento de assinatura enviado com sucesso, obrigado!', route('sistema.sua-conta.confirmacao'));
        }

        return SistemaService::jsonR(200, 0, 'Ocorreu um problema com seu pagamento! Tente novamente <br><b>Erro:' . $pagamento->errors[0]->description . '</b>', 0, 2);
    }

    public function statusPagamento(Request $request)
    {
        if ($request->event == 'invoice.status_updated') {
            $assinatura = $request->resource['subscription_code'];
            $status = $request->resource['status']['code'];
            PagamentosRepository::atualizaValidadeAssinatura($assinatura, $status);
        }
    }

    public function paypalOK(Request $request)
    {
        $assinatura = new \stdClass();
        $assinatura->code = $request->c;
        PagamentosRepository::atualizaAssinatura($this->usuario, $assinatura, 0);

        return SistemaService::jsonR(200, 1, 'Pagamento de assinatura enviado com sucesso, obrigado!', route('sistema.sua-conta.confirmacao'));
    }

    public function paypalStatus(Request $request)
    {
        $input = json_decode(json_encode($request->all()));
        Log::debug($request->all());
        $status = $input->event_type;
        if ($status == 'PAYMENT.SALE.COMPLETED') {
            $assinatura = $input->resource->billing_agreement_id;
            PagamentosRepository::atualizaValidadeAssinatura($assinatura, 3);
        }
        if ($status == 'BILLING.SUBSCRIPTION.CANCELLED' || $status == 'BILLING.SUBSCRIPTION.EXPIRED') {
            $assinatura = $input->resource->id;
            PagamentosRepository::atualizaValidadeAssinatura($assinatura, 4);
        }
        // if ($status == 'PAYMENT.SALE.DENIED') {
        //     $assinatura = $input->resource->id;
        //     PagamentosRepository::atualizaValidadeAssinatura($assinatura, 4);
        // }
    }
}
