<?php

namespace App\Http\Controllers\Sistema\Alunos;

use App\Models\Aluno;
use App\Models\Plano;
use App\Models\Aulavod;
use App\Models\Cursovod;
use App\Models\Modulovod;
use App\Models\Aulaaovivo;
use Illuminate\Support\Str;
use App\Models\Pedidoaovivo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Certificadovod;
use App\Models\Avaliacaoaovivo;
use App\Models\Professoraovivo;
use App\Models\Agendamentoaovivo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Perguntacertificadovod;
use Collective\Html\FormFacade as Form;
use Illuminate\Database\Eloquent\Model;
use App\Services\Sistema\SistemaService;
use App\Repositories\Sistema\BaseRepository;
use App\Services\Sistema\Alunos\AlunoService;
use App\Repositories\Sistema\Zoom\ZoomRepository;
use App\Notifications\Sistema\Aovivo\AulaAgendada;
use App\Http\Requests\Sistema\Alunos\UpdateRequest;
use App\Repositories\Sistema\Cursos\CursoRepository;
use App\Http\Requests\Sistema\Alunos\PerguntaRequest;
use App\Http\Requests\Sistema\Pagamento\CupomRequest;
use App\Repositories\Sistema\Alunos\AlunosRepository;
use App\Http\Requests\Sistema\Alunos\AvaliacaoRequest;
use App\Http\Requests\Sistema\Pagamento\BoletoRequest;
use App\Http\Requests\Sistema\Pagamento\CartaoRequest;
use App\Http\Requests\Sistema\Cadastro\CadastroRequest;
use App\Repositories\Sistema\Pagamentos\MoipRepository;
use App\Repositories\Sistema\Pagamentos\PedidosRepository;
use App\Notifications\Sistema\Aovivo\AulaAgendadaProfessor;
use App\Repositories\Sistema\Pagamentos\PagamentosRepository;
use App\Repositories\Sistema\Professores\ProfessorRepository;
use App\Http\Requests\Sistema\Aluno\Certificado\RespostaRequest;

class AlunoController extends Controller
{
    public function cadastro(CadastroRequest $request)
    {
        $plano = BaseRepository::find('plano', $request->plano_id);
        if ($plano->gratuito == 1) {
            $request['status_pedido'] = 2;
        }
        $aluno = BaseRepository::adicionar('aluno', $request);
        Auth::loginUsingId($aluno->id);
        if (!isset($request->from)) {
            AlunoService::mailchimp($aluno);

            return SistemaService::jsonR(200, 1, 'Cadastro realizado com sucesso!', route('sistema.vod.assinatura.cadastro.obrigado'));
        }

        return SistemaService::jsonR(200, 1, 'Cadastro realizado com sucesso!<br>Continue para o pagamento!', route('sistema.aovivo.pagar'));
    }

    public function exterior()
    {
        return view('sistema.planos-exterior', [
            'planos' => BaseRepository::all('plano'),
        ]);
    }

    public function cadastroObrigado()
    {
        return view('sistema.cadastro-obrigado', [
            'titulo' => 'Confirmação de cadastro',
            'conteudo' => BaseRepository::find('obrigadocadastro', 1),
        ]);
    }

    public function confirmar(Aluno $usuario, String $token)
    {
        if (!AlunosRepository::confirma($usuario, $token)) {
            return view('sistema.confirmacao-erro', [
                'titulo' => 'Confirmação de cadastro',
            ]);
        }

        return view('sistema.confirmacao', [
            'titulo' => 'Confirmação de cadastro',
        ]);
    }

    public function index()
    {
        return view('sistema.alunos.index', [
            'ultimos' => AlunosRepository::getLastsVod($this->usuario),
            'bannerEad' => BaseRepository::all('banneread')->first(),
            'bannerAovivo' => BaseRepository::all('banneraovivo')->first(),
        ]);
    }

    public function dados(Request $request)
    {
        return view('sistema.alunos.dados-pessoais', [
            'cidades' => BaseRepository::toSelectOther(BaseRepository::all('cidade'), 'title', 'iso'),
            'estados' => BaseRepository::toSelectOther(BaseRepository::all('estado'), 'title', 'letter'),
            'zonas' => BaseRepository::toSelectOther(BaseRepository::all('zona'), 'zone_name', 'zone_id'),
            'request' => $request,
        ]);
    }

    public function salvarDados(UpdateRequest $request)
    {
        BaseRepository::alterar('aluno', $request);

        return SistemaService::jsonR(200, 1, 'Dados atualizados com sucesso!.', route('sistema.alunos.dados'), 1);
    }

    public function upload(Aluno $aluno, Request $request)
    {
        return BaseRepository::upload($aluno, $request);
    }

    public function statusPagamentos(Request $request)
    {
        return view('sistema.alunos.pagamentos', [
            'request' => $request,
        ]);
    }

    public function alterarPlano(Request $request)
    {
        $planos = AlunosRepository::getPlanos($this->usuario);

        return view('sistema.alunos.alterar-plano', [
            'planos' => $planos,
            'request' => $request,
        ]);
    }

    public function alterarPagamento(Request $request)
    {
        return view('sistema.alunos.alterar-pagamento', [
            'request' => $request,
        ]);
    }

    public function cancelarAssinatura()
    {
        AlunosRepository::cancelaAssinatura($this->usuario);

        return SistemaService::jsonR(200, 1, 'Assinatura cancelada!', 2, 2);
    }

    public function checkCupom(CupomRequest $request)
    {
        $cupom = BaseRepository::get('cupom', ['slug' => $request->cupom])->first();
        $request['plano_id'] = $request->plano;
        $resp = PagamentosRepository::checkCupom($cupom, $request);
        if ($resp === 2) {
            return SistemaService::jsonR(200, 0, 'Este cupom perdeu a sua validade!', 0, 4);
        }
        if ($resp === 3) {
            return SistemaService::jsonR(200, 0, 'Este cupom não pode ser utilizado neste plano!', 0, 4);
        }

        return SistemaService::jsonR(200, 1, 'Cupom aplicado com sucesso!<br> Sua assinatura ficou com o valor de <b>' . currencyToApp(session('valorPlano')) . '</b> no primeiro ciclo.', 1, 2);
    }

    public function trocaAssinatura(Plano $plano)
    {
        if ($this->usuario->plano->gratuito != 1) {
            AlunosRepository::alteraPlanoAssinatura($this->usuario, $plano);
            AlunosRepository::trocaAssinatura($this->usuario, $plano, false);

            return SistemaService::jsonR(200, 1, 'Plano alterado com sucesso!<br>O novo valor virá na próxima cobrança.', 0, 2);
        }
        AlunosRepository::trocaAssinatura($this->usuario, $plano, true);

        return SistemaService::jsonR(200, 1, 'Tudo certo!<br>Continuando para o pagamento.', route('sistema.sua-conta.pagamento'));
    }

    public function alteraAssinaturaCartao(CartaoRequest $request)
    {
        $resposta = AlunosRepository::alteraAssinatura($this->usuario, 1, $request);
        if (Str::length($resposta) > 5) {
            return SistemaService::jsonR(200, 0, $resposta, 0, 4);
        }

        return SistemaService::jsonR(200, 1, 'Tudo certo!<br>Forma de pagamento alterada com sucesso!', 0, 2);
    }

    public function alteraAssinaturaBoleto(BoletoRequest $request)
    {
        $resposta = AlunosRepository::alteraAssinatura($this->usuario, 2, $request);
        if (Str::length($resposta) > 5) {
            return SistemaService::jsonR(200, 0, $resposta, 0, 4);
        }

        return SistemaService::jsonR(200, 1, 'Tudo certo!<br>Forma de pagamento alterada com sucesso!', 0, 2);
    }

    public function todosVod()
    {
        return view('sistema.alunos.todos-vod', [
            'categorias' => BaseRepository::toSelectOther(BaseRepository::all('categoriavod'), 'nome', 'slug'),
            'generos' => BaseRepository::toSelectOther(BaseRepository::all('generovod'), 'nome', 'slug'),
            'niveis' => BaseRepository::toSelectOther(BaseRepository::all('nivelvod'), 'nome', 'slug'),
            'professores' => BaseRepository::toSelectOther(BaseRepository::all('professorvod'), 'nome', 'slug'),
            'cursos' => BaseRepository::get('cursovod', ['gratuito' => 0]),
        ]);
    }

    public function cursoVod(Cursovod $curso)
    {
        return view('sistema.alunos.curso-single', [
            'curso' => $curso,
        ]);
    }

    public function cursoVodPlayer(Cursovod $curso, Modulovod $modulo, Aulavod $aula)
    {
        $status = AlunosRepository::checkAssinatura($this->usuario, $curso);
        if (!$status) {
            return response()->redirectTo(route('sistema.alunos.plano.alterar'))->withErrors(['gratuito' => 1]);
        }
        AlunosRepository::checkCurso($this->usuario, $curso, $modulo, $aula);
        $url = 'https://guitar-output.s3.amazonaws.com/' . $aula->video;
        // $url = 'https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8';
        // $url = assets('sistema/video.mp4');
        CursoRepository::signAPrivateDistribution($url);
        $pos = AlunosRepository::getPreviousNextClass($curso, $modulo, $aula);

        return view('sistema.alunos.curso-player', [
            'curso' => $curso,
            'modulo' => $modulo,
            'aula' => $aula,
            'url' => $url,
            'controles' => $pos,
        ]);
    }

    public function concluiAula(Cursovod $curso, Modulovod $modulo, Aulavod $aula)
    {
        AlunosRepository::concluiAula($this->usuario, $curso, $modulo, $aula);

        return SistemaService::jsonR(200, 1, 'Aula concluída com sucesso!', 0, 4);
    }

    public function perguntaAula(Cursovod $curso, Modulovod $modulo, Aulavod $aula, PerguntaRequest $request)
    {
        AlunosRepository::perguntaAula($this->usuario, $curso, $modulo, $aula, $request);

        return SistemaService::jsonR(200, 1, 'Pergunta enviada com sucesso!<br> Assim que ela for respondida, você será avisado e ela aparecerá aqui.', 3, 4);
    }

    public function cursoGratis(Cursovod $curso)
    {
        return view('sistema.alunos.curso-single', [
            'curso' => $curso,
        ]);
    }

    public function gratis()
    {
        return view('sistema.alunos.cursos-gratis', [
            'categorias' => BaseRepository::toSelectOther(BaseRepository::all('categoriavod'), 'nome', 'slug'),
            'generos' => BaseRepository::toSelectOther(BaseRepository::all('generovod'), 'nome', 'slug'),
            'niveis' => BaseRepository::toSelectOther(BaseRepository::all('nivelvod'), 'nome', 'slug'),
            'professores' => BaseRepository::toSelectOther(BaseRepository::all('professorvod'), 'nome', 'slug'),
            'cursos' => BaseRepository::get('cursovod', ['gratuito' => 1]),
        ]);
    }

    public function meusCursos()
    {
        return view('sistema.alunos.meus-cursos', [
            'categorias' => BaseRepository::toSelectOther(BaseRepository::all('categoriavod'), 'nome', 'slug'),
            'generos' => BaseRepository::toSelectOther(BaseRepository::all('generovod'), 'nome', 'slug'),
            'niveis' => BaseRepository::toSelectOther(BaseRepository::all('nivelvod'), 'nome', 'slug'),
            'professores' => BaseRepository::toSelectOther(BaseRepository::all('professorvod'), 'nome', 'slug'),
            'cursos' => AlunosRepository::getMeusCursos($this->usuario),
        ]);
    }

    public function meusCursosApagar(Cursovod $curso)
    {
        AlunosRepository::removeCurso($this->usuario, $curso);

        return SistemaService::jsonR(200, 1, 'Curso removido com susesso!.', 0, 2);
    }

    public function materiais()
    {
        return view('sistema.alunos.materiais', [
            'cursos' => BaseRepository::toSelectOther(AlunosRepository::getCursos($this->usuario), 'titulo', 'id'),
        ]);
    }

    public function getModulos(Request $request)
    {
        $modulos = CursoRepository::getModulos($request);

        return Form::select('modulo', [null => 'SELECIONE'] + $modulos, null, ['class' => 'modulo form-control input-white filtro', 'data-url' => route('sistema.alunos.get-aulas'), 'data-next' => 'aulas']);
    }

    public function getAulas(Request $request)
    {
        $aulas = CursoRepository::getAulas($request);

        return Form::select('aula', [null => 'SELECIONE'] + $aulas, null, ['class' => 'aula form-control input-white filtro no-select', 'data-url' => route('sistema.alunos.get-aulas'), 'data-next' => 'aulas']);
    }

    public function getMateriais(Request $request)
    {
        $materiais = CursoRepository::getMateriais($request);

        return AlunoService::downloadMateriais($materiais->unique()->sortBy('titulo'));
    }

    public function downloadMaterial(Model $model)
    {
        if ($model instanceof \App\Models\Partituravod) {
            return response()->download($model->aula->present()->getPartituraDown($model));
        }
        if ($model instanceof \App\Models\Backingtrakvod) {
            return response()->download($model->aula->present()->getBackDown($model));
        }
    }

    public function preferidos()
    {
        return view('sistema.alunos.preferidos', [
            'cursos' => AlunosRepository::getMeusCursosPreferidos($this->usuario),
        ]);
    }

    public function certificados()
    {
        return view('sistema.alunos.certificados', [
            'certificados' => AlunosRepository::certificados($this->usuario),
        ]);
    }

    public function certificado(Certificadovod $certificado)
    {
        AlunosRepository::preparaPerguntas($this->usuario, $certificado);
        $perguntas = AlunosRepository::getPergunta($this->usuario, $certificado);
        if ($perguntas) {
            return view('sistema.alunos.certificado-avaliacao', [
                'certificado' => $certificado,
                'pergunta' => AlunosRepository::getPergunta($this->usuario, $certificado),
            ]);
        }

        return response()->redirectTo(route('sistema.alunos.vod.certificado.correcao', $certificado->id));
    }

    public function responderPerguntaCertificado(Certificadovod $certificado, Perguntacertificadovod $pergunta, RespostaRequest $request)
    {
        if (AlunosRepository::responderPerguntaCertificado($this->usuario, $certificado, $pergunta, $request)) {
            return SistemaService::jsonR(200, 1, 'Resposta salva com sucesso!<br>Vamos à próxima questão.', route('sistema.alunos.vod.certificado', $certificado->id));
        }

        return SistemaService::jsonR(200, 1, 'Avaliação finalizada!<br>Vamos à correção.', route('sistema.alunos.vod.certificado.correcao', $certificado->id));
    }

    public function certificadoCorrecao(Certificadovod $certificado)
    {
        return view('sistema.alunos.certificado-correcao', [
            'certificado' => $certificado,
            'perguntas' => AlunosRepository::getPerguntasCorrecao($this->usuario, $certificado),
            'corretas' => AlunosRepository::getPerguntasCorretas($this->usuario, $certificado),
        ]);
    }

    public function refazerAvaliacao(Certificadovod $certificado)
    {
        AlunosRepository::refazPerguntas($this->usuario, $certificado);

        return response()->redirectTo(route('sistema.alunos.vod.certificado', $certificado->id));
    }

    public function gerarCertificado(Certificadovod $certificado)
    {
        AlunosRepository::gerarCertificado($this->usuario, $certificado);

        return response()->redirectTo(route('sistema.alunos.vod.certificado.ver', $certificado));
    }

    public function verCertificado(Certificadovod $certificado)
    {
        $cert = AlunosRepository::getCertificado($this->usuario, $certificado);

        return view('sistema.alunos.ver-certificado', [
            'certificado' => $cert,
        ]);
    }

    public function sair(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        Auth::guard('professor')->logout();

        return response()->redirectTo(route('sistema.index'));
    }

    public function adicionaPreferido(Cursovod $curso)
    {
        AlunosRepository::adicionaPreferido($this->usuario, $curso);

        return SistemaService::jsonR(200, 1, 'Curso adicionado com sucesso!.', 0, 4);
    }

    public function removePreferido(Cursovod $curso)
    {
        AlunosRepository::removePreferido($this->usuario, $curso);

        return SistemaService::jsonR(200, 1, 'Curso removido com sucesso!.', 0, 2);
    }

    public function aulaPreferida(Modulovod $modulo, Aulavod $aula)
    {
        AlunosRepository::adicionaAulaPreferida($this->usuario, $modulo, $aula);

        return SistemaService::jsonR(200, 1, 'Aula adicionada com sucesso!.', 0, 4);
    }

    public function removeAulaPreferida(Modulovod $modulo, Aulavod $aula)
    {
        AlunosRepository::removeAulaPreferida($this->usuario, $modulo, $aula);

        return SistemaService::jsonR(200, 1, 'Aula removida com sucesso!.', 0, 2);
    }

    public function aovivoPagarCartao(CartaoRequest $request)
    {
        $pedido = PedidosRepository::novo($this->usuario, $request, 1);
        $pagamento = PagamentosRepository::pagaCCAoVivo($pedido, $request);
        if (is_array($pagamento)) {
            return SistemaService::jsonR(200, 0, 'Ocorreu um problema com seu pagamento! Tente novamente <br><b>Erro: ' . $pagamento[0]->getDescription() . '</b>', 0, 2);
        }
        // AlunosRepository::criaAgendamentos($pedido);
        $request->session()->forget('cart');
        $request->session()->forget('cupom');

        return SistemaService::jsonR(200, 1, 'Pedido gerado com sucesso!<br>Por favor, aguarde a confirmação do pagamento para agendar suas aulas.', route('sistema.alunos.aovivo.pagamentos'));
    }

    public function aovivoPagarBoleto(BoletoRequest $request)
    {
        $pedido = PedidosRepository::novo($this->usuario, $request, 2);
        $pagamento = PagamentosRepository::pagaBoletoAoVivo($pedido, $request);
        session(['urlBoleto' => $pagamento->getHrefBoleto()]);
        $request->session()->forget('cart');
        $request->session()->forget('cupom');
        // AlunosRepository::criaAgendamentos($pedido);

        return SistemaService::jsonR(200, 1, 'Pedido gerado com sucesso!<br>Imprima ou pague seu boleto na próxima tela.', route('sistema.alunos.aovivo.pagamento.boleto'));
    }

    public function aovivoPagamentoBoleto()
    {
        return view('sistema.aovivo.pagamento-boleto');
    }

    public function aulas()
    {
        return view('sistema.alunos.aulas', []);
    }

    public function agendarPagas()
    {
        return view('sistema.alunos.agendar-pagas', []);
    }

    public function agendarPagasDisponibilidade(Agendamentoaovivo $agenda)
    {
        return view('sistema.aovivo.includes.disponibilidade-professor', [
            'agendamento' => $agenda,
            'professor' => $agenda->aula->professor,
            'categoria' => $agenda->aula->categoria,
            'aula' => $agenda->aula,
        ])->render();
    }

    public function agendarPagasDisponibilidadeProfessor(Agendamentoaovivo $agendamento, Professoraovivo $professor, Aulaaovivo $aula)
    {
        return response()->json(ProfessorRepository::disponibilidade($agendamento, $professor, $aula, $this->usuario));
    }

    public function preAgenda(Request $request)
    {
        return response()->json(AlunosRepository::preAgenda($request));
    }

    public function agendar(Request $request)
    {
        $licencas = AlunosRepository::checkLicencas($request);
        if ($licencas) {
            AlunosRepository::salvaRelatorio($request);

            return SistemaService::jsonR(503, 0, 'Por favor escolha um novo horário, não temos mais salas disponíveis para esse horário.', 0, 2);
        }
        $agendaA = AlunosRepository::agendar($request);
        if (!ZoomRepository::criaMeeting($agendaA)) {
            $agendaA->data = null;
            $agendaA->inicio = null;
            $agendaA->fim = null;
            $agendaA->save();

            return SistemaService::jsonR(503, 0, 'Ocorreu um erro no momento do agendamento. Por favor tente agendar a aula novamente.', 0, 2);
        }
        $agendaA->aluno->notify(new AulaAgendada($agendaA));
        $agendaA->professor->notify(new AulaAgendadaProfessor($agendaA));

        return SistemaService::jsonR(200, 1, 'Agendamento realizado com sucesso!', 0, 2);
    }

    public function pagamentosAoVivo(Request $request)
    {
        return view('sistema.alunos.pagamentos-aovivo', [
            'request' => $request,
        ]);
    }

    public function cancelaPedidoAovivo(Pedidoaovivo $pedido)
    {
        if (AlunosRepository::checkAutor('pedidoaovivo', $pedido->id, $this->usuario)) {
            MoipRepository::cancelaPedidoAovivo($pedido);

            return SistemaService::jsonR(200, 1, 'Pedido cancelado com sucesso!', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function avaliacoes()
    {
        return view('sistema.alunos.avaliacoes', []);
    }

    public function avaliar(Avaliacaoaovivo $avaliacao, AvaliacaoRequest $request)
    {
        AlunosRepository::avaliar($avaliacao, $request);

        return SistemaService::jsonR(200, 1, 'Avaliação realizada com sucesso!', 0, 2);
    }

    public function getPreferidos(Request $request)
    {
        return AlunoService::preferidos($this->usuario, $request);
    }

    public function iniciaAula(Request $request)
    {
        $agendamento = BaseRepository::find('agendamentoaovivo', $request->i);
        $agendamento->status = 1;
        $agendamento->save();
    }

    public function finalizaAula()
    {
        $aulas = BaseRepository::get('agendamentoaovivo', ['status' => 1]);
        if ($aulas->count() > 0) {
            foreach ($aulas as $a) {
                if (now()->greaterThan(\Carbon\Carbon::createFromDate($a->data . ' ' . $a->fim)) && $a->meeting != null) {
                    ZoomRepository::encerraMeeting($a);
                    $a->status = 2;
                    $a->save();
                    AlunosRepository::criaAvaliacao($a);
                }
            }
        }
    }

    public function reagendamento(Request $request)
    {
        $agendamento = BaseRepository::find('agendamentoaovivo', $request->id);
        if (AlunosRepository::checkAutor('agendamentoaovivo', $request->id, $agendamento->aluno)) {
            AlunosRepository::reagendaAula($agendamento);

            return SistemaService::jsonR(200, 1, 'Aula disponível para novo agendamento!', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }
}
