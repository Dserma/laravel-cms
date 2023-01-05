<?php

namespace App\Http\Controllers\Sistema\Professores;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Avaliacaoaovivo;
use App\Models\Professoraovivo;
use App\Http\Controllers\Controller;
use App\Services\Sistema\SistemaService;
use App\Notifications\Sistema\ContaAlterada;
use App\Repositories\Sistema\BaseRepository;
use App\Http\Requests\Sistema\Professores\AulaRequest;
use App\Services\Sistema\Professores\ProfessorService;
use App\Http\Requests\Sistema\Professores\CupomRequest;
use App\Repositories\Sistema\Pagamentos\MoipRepository;
use App\Http\Requests\Sistema\Professores\CadastroRequest;
use App\Http\Requests\Sistema\Professores\PacoteAulaRequest;
use App\Repositories\Sistema\Pagamentos\MoipAoVivoRepository;
use App\Repositories\Sistema\Professores\ProfessorRepository;
use App\Http\Requests\Sistema\Professores\NovaCategoriaRequest;
use App\Http\Requests\Sistema\Professores\DadosFinanceirosRequest;
use App\Http\Requests\Sistema\Professores\DisponibilidadeProfessorRequest;
use App\Models\Disponibilidadeprofessoraovivo;
use App\Notifications\NovaCategoria;

class ProfessorController extends Controller
{
    public function index()
    {
        return view('sistema.dash-professor.index', [
            'informacoes' => BaseRepository::find('informacaofinanceira', 1),
            'bancos' => BaseRepository::all('banco'),
            'resgate' => ProfessorRepository::liberado($this->usuario),
            'realizadas' => ProfessorRepository::pendente($this->usuario),
            'naoRealizadas' => ProfessorRepository::naoRealizadas($this->usuario),
            'bloqueado' => ProfessorRepository::bloqueado($this->usuario),
        ]);
    }

    public function meusDados()
    {
        return view('sistema.dash-professor.meus-dados', [
            'categorias' => BaseRepository::toSelect(BaseRepository::all('categoriaaovivo')),
            'cidades' => BaseRepository::toSelectOther(BaseRepository::all('cidade'), 'title', 'iso'),
            'estados' => BaseRepository::toSelectOther(BaseRepository::all('estado'), 'title', 'letter'),
            'zonas' => BaseRepository::toSelectOther(BaseRepository::all('zona'), 'zone_name', 'zone_id'),
        ]);
    }

    public function meusDadosSalvar(CadastroRequest $request)
    {
        $obj = BaseRepository::alterar('professoraovivo', $request);
        MoipRepository::checkConta($request);
        BaseRepository::relations($obj, 'categorias', $request);
        if ($this->usuario->disponibilidades()->exists()) {
            return SistemaService::jsonR(200, 1, 'Dados atualizados com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(200, 1, 'Dados atualizados com sucesso!.', route('sistema.dash-professor.financeiro'));
    }

    public function avatarUpload(Professoraovivo $professor, Request $request)
    {
        return BaseRepository::upload($professor, $request);
    }

    public function imagensUpload(Professoraovivo $professor, Request $request)
    {
        return ProfessorRepository::uploadImagens($professor, $request);
    }

    public function imagemApagar(Professoraovivo $professor, Request $request)
    {
        return ProfessorRepository::apagarImagens($professor, $request);
    }

    public function financeiro()
    {
        return view('sistema.dash-professor.financeiro', [
            'informacoes' => BaseRepository::find('informacaofinanceira', 1),
            'bancos' => BaseRepository::all('banco'),
            'resgate' => ProfessorRepository::liberado($this->usuario),
            'realizadas' => ProfessorRepository::pendente($this->usuario),
            'naoRealizadas' => ProfessorRepository::naoRealizadas($this->usuario),
            'bloqueado' => ProfessorRepository::bloqueado($this->usuario),
        ]);
    }

    public function financeiroSalvar(DadosFinanceirosRequest $request)
    {
        $request['id'] = $this->usuario->id;
        $request['alterou_conta'] = 1;
        $request['token_alteracao'] = Str::random(100);
        BaseRepository::alterar('professoraovivo', $request);
        $this->usuario->refresh();
        $this->usuario->notify(new ContaAlterada());
        if ($this->usuario->disponibilidades()->exists()) {
            return SistemaService::jsonR(200, 1, 'Seus dados foram gravados, mas, <b>eles só serão utilizados após a confirmação do e-mail enviado para você.</b>', 0, 2);
        }

        return SistemaService::jsonR(200, 1, 'Seus dados foram gravados, mas, <b>eles só serão utilizados após a confirmação do e-mail enviado para você.</b>', route('sistema.dash-disponibilidade'));
    }

    public function confirmaFinanceiro(Professoraovivo $professor, String $token)
    {
        if ($professor->token_alteracao === $token) {
            ProfessorRepository::alteraFinanceiro($this->usuario);

            return response()->redirectTo(route('sistema.dash-professor.financeiro'))->withErrors(['atualizaok' => 1]);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function transferencia()
    {
        MoipAoVivoRepository::transferencia($this->usuario);

        return SistemaService::jsonR(200, 1, 'Solicitação de transferência realizada com sucesso!.', 0, 2);
    }

    public function agenda()
    {
        return view('sistema.dash-professor.minha-agenda', []);
    }

    public function disponibilidade()
    {
        return view('sistema.dash-professor.disponibilidade', [
            'aulas' => ProfessorRepository::aulasPacote($this->usuario),
            'alunos' => ProfessorRepository::alunosAtivos($this->usuario),
        ]);
    }

    public function disponibilidadeSalvar(DisponibilidadeProfessorRequest $request)
    {
        if ($request->id == null) {
            BaseRepository::adicionar('disponibilidadeprofessoraovivo', $request);

            if ($this->usuario->aulas()->exists()) {
                return SistemaService::jsonR(200, 1, 'Disponibilidade adicionada com sucesso!.', 0, 2);
            }

            return SistemaService::jsonP(200, 9, 'Disponibilidade adicionada com sucesso!.<br>Deseja cadastrar mais uma disponibilidade?', route('sistema.dash-disponibilidade'), route('sistema.dash-professor.aulas'));
        }

        if (ProfessorRepository::checkAutor('disponibilidadeprofessoraovivo', $request->id, $this->usuario)) {
            BaseRepository::alterar('disponibilidadeprofessoraovivo', $request);

            return SistemaService::jsonR(200, 1, 'Disponibilidade alterada com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function aulas()
    {
        if (!ProfessorRepository::checkCategorias($this->usuario)) {
            return response()->redirectTo(route('sistema.dash-professor.dados'))->withErrors(['categorias' => 1]);
        }

        if (!ProfessorRepository::checkDisponibilidade($this->usuario)) {
            return response()->redirectTo(route('sistema.dash-disponibilidade'))->withErrors(['disponibilidades' => 1]);
        }

        return view('sistema.dash-professor.aulas', [
            'categorias' => BaseRepository::toSelect($this->usuario->categorias),
        ]);
    }

    public function aulasSalvar(AulaRequest $request)
    {
        if ($request->id == null) {
            BaseRepository::adicionar('aulaaovivo', $request);

            if ($this->usuario->aulas->count() > 1) {
                return SistemaService::jsonR(200, 1, 'Aula adicionada com sucesso!.', 0, 2);
            } else {
                return SistemaService::jsonR(200, 1, '<b>Seu cadastro foi concluído com sucesso!</b><br>Você já pode começar a vender suas aulas e ganhar dinheiro em nossa plataforma!!<br><br>Caso queira cadastrar mais aulas, basta continuar nesta tela.', 0, 2);
            }
        }

        if (ProfessorRepository::checkAutor('aulaaovivo', $request->id, $this->usuario)) {
            BaseRepository::alterar('aulaaovivo', $request);

            return SistemaService::jsonR(200, 1, 'Aula alterada com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function pacotes()
    {
        if (!ProfessorRepository::checkCategorias($this->usuario)) {
            return response()->redirectTo(route('sistema.dash-professor.dados'))->withErrors(['categorias' => 1]);
        }

        return view('sistema.dash-professor.pacotes', [
            'aulas' => ProfessorRepository::aulasPacote($this->usuario),
        ]);
    }

    public function pacotesSalvar(PacoteAulaRequest $request)
    {
        if ($request->id == null) {
            BaseRepository::adicionar('pacoteaulaaovivo', $request);

            return SistemaService::jsonR(200, 1, 'Pacote adicionado com sucesso!.', 0, 2);
        }

        if (ProfessorRepository::checkAutor('pacoteaulaaovivo', $request->id, $this->usuario)) {
            BaseRepository::alterar('pacoteaulaaovivo', $request);

            return SistemaService::jsonR(200, 1, 'Pacote alterado com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function cupons()
    {
        if (!ProfessorRepository::checkCategorias($this->usuario)) {
            return response()->redirectTo(route('sistema.dash-professor.dados'))->withErrors(['categorias' => 1]);
        }

        return view('sistema.dash-professor.cupons', [
            'categorias' => ProfessorRepository::getCategorias($this->usuario),
            'aulas' => ProfessorRepository::aulasPacote($this->usuario),
        ]);
    }

    public function cuponsSalvar(CupomRequest $request)
    {
        if ($request->id == null) {
            BaseRepository::adicionar('cupomaovivo', $request);

            return SistemaService::jsonR(200, 1, 'Cupom adicionado com sucesso!.', 0, 2);
        }

        if (ProfessorRepository::checkAutor('cupomaovivo', $request->id, $this->usuario)) {
            BaseRepository::alterar('cupomaovivo', $request);

            return SistemaService::jsonR(200, 1, 'Cupom alterado com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function avaliacoes()
    {
        if (!ProfessorRepository::checkCategorias($this->usuario)) {
            return response()->redirectTo(route('sistema.dash-professor.dados'))->withErrors(['categorias' => 1]);
        }

        return view('sistema.dash-professor.avaliacoes', [
            'categorias' => ProfessorRepository::getCategorias($this->usuario),
            'aulas' => ProfessorRepository::aulasPacote($this->usuario),
        ]);
    }

    public function avaliacaoGravar(Request $request)
    {
        BaseRepository::alterar('avaliacaoaovivo', $request);

        return SistemaService::jsonR(200, 1, 'Aluno avaliado com sucesso!.', 0, 2);
    }

    public function getAulas(Request $request)
    {
        $aulas = ProfessorRepository::getAulas($this->usuario, $request);

        return ProfessorService::comboAulas($aulas);
    }

    public function excluir(String $model, int $id)
    {
        if (ProfessorRepository::checkAutor($model, $id, $this->usuario)) {
            BaseRepository::delete($model, $id);

            return SistemaService::jsonR(200, 1, 'Registro excluído com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(200, 0, 'Ação não permitida!.', 0, 2);
    }

    public function encerraDisputa(Avaliacaoaovivo $avaliacao)
    {
        if (ProfessorRepository::checkAutor('avaliacaoaovivo', $avaliacao->id, $this->usuario)) {
            ProfessorRepository::encerraDisputa($avaliacao);

            return SistemaService::jsonR(200, 1, 'A disputa foi encerrada com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function reagendarAulaSemAvaliacao(Request $request)
    {
        $agendamento = BaseRepository::find('agendamentoaovivo', $request->id);
        if (ProfessorRepository::checkAutor('agendamentoaovivo', $agendamento->id, $this->usuario)) {
            ProfessorRepository::reagendaAulaSemAvaliacao($agendamento);

            return SistemaService::jsonR(200, 1, 'Aula liberada para reagendamento com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function reagendarAula(Avaliacaoaovivo $avaliacao)
    {
        if (ProfessorRepository::checkAutor('avaliacaoaovivo', $avaliacao->id, $this->usuario)) {
            ProfessorRepository::reagendaAula($avaliacao);

            return SistemaService::jsonR(200, 1, 'Aula liberada para reagendamento com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function removerAvaliacao(Avaliacaoaovivo $avaliacao)
    {
        if (ProfessorRepository::checkAutor('avaliacaoaovivo', $avaliacao->id, $this->usuario)) {
            ProfessorRepository::remove($avaliacao);

            return SistemaService::jsonR(200, 1, 'Comentário removido de sua página com sucesso!.', 0, 2);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function getItem(String $model, Int $id)
    {
        if (ProfessorRepository::checkAutor($model, $id, $this->usuario)) {
            return BaseRepository::find($model, $id);
        }

        return SistemaService::jsonR(401, 0, 'Ação não permitida!.', 0, 2);
    }

    public function novaCategoria(NovaCategoriaRequest $request)
    {
        User::all()->each(function ($u) use ($request) {
            $request['p'] = $this->usuario->fullName;
            $u->notify(new NovaCategoria($request));
        });

        return SistemaService::jsonR(200, 1, 'Contato enviado com sucesso!<br>Em breve entraremos em contato com você. Obrigado!', 0, 4);
    }

    public function detalhes(Professoraovivo $professor, Int $tipo)
    {
        switch ($tipo) {
            case 0:
                $ret = ProfessorRepository::getLiberado($professor)->get();
                $titulo = 'Disponível para resgate';

                break;

            case 1:
                $ret = ProfessorRepository::getPendente($professor)->get();
                $titulo = 'Aulas já realizadas, a menos de 30 dias';

                break;

            case 2:
                $ret = ProfessorRepository::getNaoRealizadas($professor)->get();
                $titulo = 'Aulas não realizadas';

                break;

            case 3:
                $ret = ProfessorRepository::getBloqueado($professor)->get();
                $titulo = 'Aulas bloqueadas';

                break;
        }

        return view('sistema.dash-professor.detalhes-financeiros', [
            'titulo' => $titulo,
            'lista' => $ret->sortByDesc('data'),
        ]);
    }

    public static function reorder(Request $request)
    {
        $model = new Disponibilidadeprofessoraovivo();
        $obj = $model::where('id', $request->i)
            ->when($model->orderKey != null, function ($q) use ($model, $request) {
                return $q->where($model->orderKey, $request->k);
            })->first();
        $obj->order = $request->p;
        $obj->save();
    }
}
