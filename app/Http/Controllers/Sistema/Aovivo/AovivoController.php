<?php

namespace App\Http\Controllers\Sistema\Aovivo;

use App\Models\Aulaaovivo;
use Illuminate\Http\Request;
use App\Models\Professoraovivo;
use App\Traits\Sistema\Handler;
use App\Http\Controllers\Controller;
use App\Services\Sistema\SistemaService;
use App\Services\Sistema\Alunos\AlunoService;
use App\Http\Requests\Sistema\Aovivo\CupomCheckout;
use App\Repositories\Sistema\BaseRepository as SistemaBaseRepository;
use App\Services\Sistema\Professores\ProfessorService;
use App\Repositories\Sistema\Alunos\AlunosRepository;
use App\Repositories\Sistema\Pagamentos\PedidosRepository;
use App\Repositories\Sistema\Professores\ProfessorRepository;

class AovivoController extends Controller
{
    use Handler;

    public function getAulas(Professoraovivo $professor, Request $request)
    {
        $aulas = ProfessorRepository::getAulas($professor, $request);

        return ProfessorService::tempoAulas($aulas);
    }

    public function agendaAula(Professoraovivo $professor, Request $request)
    {
        AlunosRepository::agenda($professor, $request);
    }

    public function atualizaCart(Request $request)
    {
        $cart = AlunosRepository::getCart();

        return AlunoService::produtosCart($cart);
    }

    public function atualizaValor(Request $request)
    {
        session(['totalCart' => $request->t]);
    }

    public function removeCart(Aulaaovivo $aula, Request $request)
    {
        AlunosRepository::removeCart($aula, $request);
    }

    public function pagar()
    {
        return view('sistema.aovivo.pagamento');
    }

    public function cupom(CupomCheckout $request)
    {
        if (AlunosRepository::checkCupom($request)) {
            return SistemaService::jsonR(200, 1, 'Cupom aplicado com sucesso!', 0, 2);
        }

        return SistemaService::jsonR(200, 0, 'Cupom inválido!', 0, 4);
    }

    public function statusPagamento(Request $request)
    {
        // pre(json_decode($request->getContent()));
        $data = json_decode($request->getContent(), false);
        if (isset($data->resource) && is_object($data->resource)) {
            $payment = $data->resource->payment->id;
            $status = $data->resource->payment->status;
            PedidosRepository::atualizaPedido($payment, $status);
        }
    }

    public function previaAgenda(Professoraovivo $professor)
    {
        // pre(ProfessorRepository::previaAgenda($professor));

        return view('sistema.aovivo.includes.previa-professor', [
            'professor' => $professor,
            'eventos' => ProfessorRepository::previaAgenda($professor),
        ]);
    }

    public function previaAgendaGet(Professoraovivo $professor)
    {
        return response()->json(ProfessorRepository::previaAgenda($professor));
    }

    public function termoProfessor()
    {
        return view('sistema.aovivo.termo-professor', [
            'conteudo' => SistemaBaseRepository::find('termoprofessor', 1),
        ]);
    }
}
