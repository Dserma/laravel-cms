<?php

namespace App\Http\Controllers\Sistema;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Categoriavod;
use App\Models\Professorvod;
use Illuminate\Http\Request;
use App\Models\Categoriaaovivo;
use App\Models\Professoraovivo;
use App\Traits\Sistema\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContatoEnviado;
use Illuminate\Support\Facades\Session;
use App\Services\Sistema\SistemaService;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\Sistema\BaseRepository;
use App\Http\Requests\Sistema\ContatoRequest;
use App\Http\Requests\Sistema\Login\LoginRequest;
use App\Repositories\Sistema\Auth\AuthRepository;
use App\Repositories\Sistema\Alunos\AlunosRepository;
use App\Repositories\Sistema\Professores\ProfessorRepository;
use App\Http\Requests\Sistema\Cadastro\CadastroProfessorRequest;

class AppController extends Controller
{
    use Handler;

    public function index()
    {
        return view('sistema.index', [
            'banners' => BaseRepository::all('banner'),
            'depoimentos' => BaseRepository::all('depoimento'),
            'categorias' => BaseRepository::all('categoriavod'),
            'professores' => BaseRepository::all('professorvod'),
            'professoresA' => Professoraovivo::whereHas('aulas')->where('status', 1)->inRandomOrder()->limit(6)->get(),
            'sobre' => BaseRepository::find('sobrenos', 1),
        ]);
    }

    public function aluno()
    {
        return view('sistema.aluno', [
            'categorias' => BaseRepository::all('categoriavod'),
            'professores' => BaseRepository::all('professorvod'),
            'depoimentos' => BaseRepository::all('depoimento'),
            'sobre' => BaseRepository::find('sobrenos', 1),
            'como' => BaseRepository::find('comofuncionaaluno', 1),
        ]);
    }

    public function aulasAoVivo(Request $request, Categoriaaovivo $categoria = null)
    {
        $this->configs->titulo_home = $this->configs->titulo_aovivo;
        $this->configs->description_home = $this->configs->description_aovivo;
        $this->configs->keywords_home = $this->configs->keywords_aovivo;

        return view('sistema.aovivo', [
            'categorias' => BaseRepository::all('categoriaaovivo'),
            'professores' => ProfessorRepository::getProfessores($request, $categoria),
            'request' => $request,
            'cat' => $categoria,
        ]);
    }

    public function aulasAoVivoProfessor(Professoraovivo $professor)
    {
        $this->configs->titulo_home = $professor->titulo_seo;
        $this->configs->description_home = $professor->description_seo;
        $this->configs->keywords_home = $professor->keywords_seo;

        return view('sistema.professor-aovivo', [
            'professor' => $professor,
            'aula' => $professor->aulas->sortBy('valor')->first(),
        ]);
    }

    public function sejaProfessor(Request $request)
    {
        return view('sistema.seja-professor', [
            'professores' => ProfessorRepository::getProfessores($request, null),
            'depoimentos' => BaseRepository::all('depoimento'),
            'sobre' => BaseRepository::find('sobrenos', 1),
            'como' => BaseRepository::find('comofuncionaprofessor', 1),
        ]);
    }

    public function sejaProfessorCadastro()
    {
        return view('sistema.professores.cadastro', []);
    }

    public function sejaProfessorCadastrar(CadastroProfessorRequest $request)
    {
        $professor = ProfessorRepository::cadastra($request);
        Auth::guard('professor')->login($professor, true);

        return SistemaService::jsonR(200, 1, 'VAMOS CADASTRAR UMA AULA? <br>Para completar seu cadastro e oferecer suas aulas no Guitarpedia. clique em OK.', route('sistema.dash-professor.dados'));
    }

    public function professor(Categoriavod $categoria, Professorvod $professor)
    {
        return view('sistema.professores.single', [
            'professor' => $professor,
            'categorias' => BaseRepository::all('categoriavod'),
        ]);
    }

    public function professores(Categoriavod $categoria = null)
    {
        if ($categoria == null) {
            $professores = BaseRepository::all('professorvod');
        } else {
            $professores = BaseRepository::get('professorvod', ['categoriavod_id' => $categoria->id]);
        }

        return view('sistema.professores.index', [
            'professores' => $professores,
            'categorias' => BaseRepository::all('categoriavod'),
        ]);
    }

    public function aulasGratuitas()
    {
        return view('sistema.aulas-gratuitas', [
            'categorias' => BaseRepository::all('categoriavod'),
        ]);
    }

    public function quemSomos()
    {
        return view('sistema.quem-somos', [
            'sobre' => BaseRepository::find('sobrenos', 1),
        ]);
    }

    public function historia()
    {
        return view('sistema.historia', [
            'sobre' => BaseRepository::find('sobrenos', 1),
        ]);
    }

    public function ajuda(Request $request)
    {
        $faqs = BaseRepository::faqs($request);

        return view('sistema.ajuda', [
            'categorias' => BaseRepository::toSelect(BaseRepository::all('categoriaajuda')),
            'faqs' => $faqs,
            'request' => $request,
        ]);
    }

    public function termos()
    {
        return view('sistema.termos', [
            'conteudo' => BaseRepository::find('termo', 1),
        ]);
    }

    public function planos()
    {
        return view('sistema.planos', [
            'planos' => BaseRepository::order('plano'),
            'sobre' => BaseRepository::find('sobrenos', 1),
        ]);
    }

    public function blog()
    {
        return view('sistema.blog', []);
    }

    public function politica()
    {
        return view('sistema.politica', [
            'conteudo' => BaseRepository::find('politica', 1),
        ]);
    }

    public function contato()
    {
        return view('sistema.contato', []);
    }

    public function contatoEnvia(ContatoRequest $request)
    {
        User::all()->each(function ($u) use ($request) {
            $u->notify(new ContatoEnviado($request));
        });

        return SistemaService::jsonR(200, 1, 'Contato enviado com sucesso!<br>Em breve entraremos em contato com você. Obrigado!', route('sistema.index'));
    }

    public function auth()
    {
        return view('sistema.auth', [
            'plano' => BaseRepository::get('plano', ['gratuito' => 1])->first()->id,
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (Str::replaceFirst(url('/'), '', url()->previous()) != '/sair' && Str::replaceFirst(url('/'), '', url()->previous()) != '/auth' && !$request->painel) {
            session()->put('from', url()->previous());
        } else {
            session()->forget('from');
        }
        $login = AuthRepository::login($request);
        if ($login == 'a') {
            if ($request->plano && $request->plano != '') {
                $resp = AlunosRepository::checkCadastro(Auth::user(), $request->plano);
                if ($resp == 0) {
                    return SistemaService::jsonR(200, 1, '<b>Você ainda não possui uma assinatura paga!</b><br>Por favor, insira seus dados de cobrança na próxima tela.', route('sistema.sua-conta.pagamento'));
                }
                if ($resp == 1) {
                    return SistemaService::jsonR(200, 1, 'Você já possui uma assinatura em nosso site!<br><br>Por favor, faça a alteração da mesma na próxima tela.', route('sistema.alunos.plano.alterar', $request->plano));
                }
            }
            if ($request->painel) {
                return SistemaService::jsonR(200, 1, 'Logado com sucesso!', route('sistema.alunos.index'));
            }

            return SistemaService::jsonR(200, 1, 'Logado com sucesso!', Redirect::intended('/')->getTargetUrl());
        }
        if ($login == 'p') {
            if (!Session::get('url.intended')) {
                return SistemaService::jsonR(200, 1, 'Logado com sucesso!', route('sistema.dash-professor.index'));
            }

            return SistemaService::jsonR(200, 1, 'Logado com sucesso!', Redirect::intended('/')->getTargetUrl());
        }

        return SistemaService::jsonR(200, 2, 'Senha incorreta!', 0, 4);
    }

    public function zoom(Request $request)
    {
        $configs = BaseRepository::find('configuracoes', 1);
        $configs->zoomcode = $request->code;
        $configs->save();
    }

    public function evolucao()
    {
        return view('sistema.evolucao');
    }

    public function completo()
    {
        return view('sistema.lp');
    }
}
