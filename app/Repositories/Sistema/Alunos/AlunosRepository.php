<?php

namespace App\Repositories\Sistema\Alunos;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Plano;
use App\Models\Aulavod;
use App\Models\Cursovod;
use App\Models\Modulovod;
use App\Models\Aulaaovivo;
use App\Models\Semlicenca;
use App\Models\Perguntavod;
use Illuminate\Support\Str;
use App\Models\Pedidoaovivo;
use Illuminate\Http\Request;
use App\Models\Certificadovod;
use App\Models\Historicoaluno;
use App\Models\Avaliacaoaovivo;
use App\Models\Professoraovivo;
use App\Models\Agendamentoaovivo;
use App\Models\Perguntacertificadovod;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;
use App\Notifications\NovaSenhaNotification;
use App\Repositories\Sistema\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Sistema\Aovivo\CupomCheckout;
use App\Notifications\AlteraAssinaturaNotification;
use App\Http\Requests\Sistema\Alunos\PerguntaRequest;
use App\Notifications\NovaSenhaProfessorNotification;
use App\Notifications\SuspendeAssinaturaNotification;
use App\Http\Requests\Sistema\Alunos\AvaliacaoRequest;
use App\Repositories\Sistema\Pagamentos\MoipRepository;
use App\Http\Requests\Sistema\Login\EsqueciSenhaRequest;
use App\Notifications\Sistema\Aovivo\AulaReAgendadaProfessor;
use App\Repositories\Sistema\Professores\ProfessorRepository;
use App\Notifications\Sistema\Alunos\NovaPerguntaNotification;
use App\Http\Requests\Sistema\Aluno\Certificado\RespostaRequest;
use App\Notifications\SemLicencaNotification;

class AlunosRepository
{
    private static $aulaPos = [];

    public static function confirma(Aluno $usuario, String $token)
    {
        if ($usuario->confirmation_token !== $token || $usuario->confirmation_token === null) {
            return false;
        }
        $usuario->confirmation_token = null;
        $usuario->save();

        return true;
    }

    public static function recuperarSenha(EsqueciSenhaRequest $request)
    {
        $aluno = Aluno::where('email', $request->email)->first();
        if ($aluno) {
            $aluno->notify(new NovaSenhaNotification());
        }
        $professor = Professoraovivo::where('email', $request->email)->first();
        if ($professor) {
            $professor->notify(new NovaSenhaProfessorNotification());
        }
    }

    public static function gravaPlano(Aluno $aluno, Plano $plano)
    {
        $aluno->plano_id = $plano->id;
        $aluno->save();
        $aluno->refresh();
    }

    public static function checkCadastro(Aluno $aluno, Int $plano_id)
    {
        if ($aluno->plano->gratuito == 1) {
            self::alteraPlano($aluno, $plano_id);

            return 0;
        }
        if ($aluno->assinatura_gateway_id == null) {
            self::alteraPlano($aluno, $plano_id);

            return 0;
        }

        return 1;
    }

    public static function alteraPlano(Aluno $aluno, Int $plano)
    {
        $aluno->plano_id = $plano;
        $aluno->save();
        $aluno->refresh();
    }

    public static function getLastsVod(Aluno $aluno)
    {
        return $aluno->cursos()->orderBy('pivot_updated_at', 'DESC')->get()->slice(0, 10);
    }

    public static function checkAssinatura(Aluno $aluno, Cursovod $curso)
    {
        if ($curso->gratuito == 1) {
            return true;
        }

        if (($aluno->plano->gratuito == 1 && $aluno->plano->exibir == 1) && $curso->gratuito != 1) {
            return false;
        }

        if (!$aluno->validade_assinatura && ($aluno->plano->gratuito != 1 && $aluno->plano->exibir == 1)) {
            return false;
        }

        if ($aluno->validade_assinatura . ' 23:59:59' < Carbon::now() && ($aluno->plano->gratuito != 1 && $aluno->plano->exibir == 1)) {
            return false;
        }

        return true;
    }

    public static function checkCurso(Aluno $aluno, Cursovod $curso, Modulovod $modulo, Aulavod $aula)
    {
        if (!$aluno->cursos->contains($curso)) {
            $aluno->cursos()->attach($curso);
        }

        if (!$aluno->modulos->contains($modulo)) {
            $aluno->modulos()->attach($modulo, ['cursovod_id' => $curso->id]);
        }

        $aulaAtual = $aluno->aulas()->where('aulavod_id', $aula->id)->get();
        if ($aulaAtual) {
            $temAula = 0;
            foreach ($aulaAtual as $a) {
                if ($a->pivot->modulovod_id == $modulo->id) {
                    $temAula++;
                }
            }
            if ($temAula == 0) {
                $aluno->aulas()->attach($aula, ['modulovod_id' => $modulo->id]);
            }
        }
        $aluno->refresh();
        $aluno->modulos()->updateExistingPivot($modulo->id, ['updated_at' => Carbon::now()]);
        $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->updateExistingPivot($aula->id, ['updated_at' => Carbon::now()]);
        $aluno->cursos()->updateExistingPivot($curso->id, ['updated_at' => Carbon::now()]);
    }

    public static function getPreviousNextClass(Cursovod $curso, Modulovod $modulo, Aulavod $aula)
    {
        $retorno = [];
        self::getClassPositions($curso);
        $aulas = self::$aulaPos;
        $atual = "$modulo->slug<>$aula->slug";
        $posAtual = array_search($atual, $aulas);
        if ($posAtual == array_key_first($aulas)) {
            $retorno['anterior'] = false;
        } else {
            $anterior = $aulas[$posAtual - 1];
            $anteriores = explode('<>', $anterior);
            $retorno['anterior'] = route('sistema.alunos.vod.curso.player', [$curso->slug, reset($anteriores), end($anteriores)]);
        }
        if ($posAtual == array_key_last($aulas)) {
            $retorno['proximo'] = false;
        } else {
            $proximo = $aulas[$posAtual + 1];
            $proximos = explode('<>', $proximo);
            $retorno['proximo'] = route('sistema.alunos.vod.curso.player', [$curso->slug, reset($proximos), end($proximos)]);
        }

        return $retorno;
    }

    public static function concluiAula(Aluno $aluno, Cursovod $curso, Modulovod $modulo, Aulavod $aula)
    {
        $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->updateExistingPivot($aula->id, ['status' => 1]);
        $aluno->refresh();
        self::checkModulo($aluno, $curso, $modulo);
    }

    public static function checkModulo(Aluno $aluno, Cursovod $curso, Modulovod $modulo)
    {
        $aFazer = $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->wherePivot('status', 0)->get()->count();
        if ($aFazer == 0) {
            $aluno->modulos()->updateExistingPivot($modulo->id, ['status' => 1]);
            $aluno->refresh();
            self::checkAvaliacoes($aluno, $curso, $modulo);
        }
    }

    public static function checkCursoStatus(Aluno $aluno, Cursovod $curso, Modulovod $modulo)
    {
        $aFazer = $aluno->modulos()->wherePivot('cursovod_id', $curso->id)->wherePivot('status', 0)->get()->count();
        if ($aFazer == 0) {
            $aluno->cursos()->updateExistingPivot($curso->id, ['status' => 1]);
            $aluno->refresh();
            self::checkAvaliacoes($aluno, $curso, $modulo);
        }
    }

    public static function checkAvaliacoes(Aluno $aluno, Cursovod $curso, Modulovod $modulo)
    {
        $certificados = BaseRepository::get('certificadovod', ['cursovod_id' => $curso->id]);
        foreach ($certificados as $cert) {
            if ($cert->modulovod_id != null) {
                if ($cert->modulovod_id == $modulo->id) {
                    if (!$aluno->certificados->contains($cert->id)) {
                        $aluno->certificados()->attach($cert->id);
                    }
                }
            } else {
                if ($cert->cursovod_id == $curso->id) {
                    if (!$aluno->certificados->contains($cert->id)) {
                        $aluno->certificados()->attach($cert->id);
                    }
                }
            }
        }
    }

    public static function getClassPositions(Cursovod $curso)
    {
        $curso->modulos->each(function ($m) {
            $m->aulas->pluck('slug')->each(function ($a) use ($m) {
                self::$aulaPos[] = $m->slug . '<>' . $a;
            });
        });
    }

    public static function getCursos(Aluno $aluno)
    {
        if ($aluno->plano->gratuito == 1) {
            return BaseRepository::get('cursovod', ['gratuito' => 1]);
        }

        return BaseRepository::get('cursovod', ['gratuito' => 0]);
    }

    public static function getMeusCursos(Aluno $aluno)
    {
        return $aluno->cursos;
    }

    public static function getMeusCursosPreferidos(Aluno $aluno)
    {
        return $aluno->cursos()->wherePivot('preferido', 1)->get();
    }

    public static function getMinhasAulasPreferidas(Aluno $aluno)
    {
        return $aluno->aulas()->wherePivot('preferida', 1)->get();
    }

    public static function removeCurso(Aluno $aluno, Cursovod $curso)
    {
        $aluno->cursos()->detach($curso->id);
    }

    public static function perguntaAula(Aluno $aluno, Cursovod $curso, Modulovod $modulo, Aulavod $aula, PerguntaRequest $request)
    {
        $pergunta = new Perguntavod();
        $pergunta->aluno_id = $aluno->id;
        $pergunta->cursovod_id = $curso->id;
        $pergunta->modulovod_id = $modulo->id;
        $pergunta->aulavod_id = $aula->id;
        $pergunta->pergunta = $request->pergunta;
        $pergunta->save();
        User::all()->each(function ($u) use ($request) {
            $u->notify(new NovaPerguntaNotification());
        });
    }

    public static function certificados(Aluno $aluno)
    {
        return $aluno->certificados;
    }

    public static function preparaPerguntas(Aluno $aluno, Certificadovod $certificado)
    {
        foreach ($certificado->perguntas->where('certificadovod_id', $certificado->id) as $pergunta) {
            if (!$aluno->perguntasCertificados->contains($pergunta->id)) {
                $aluno->perguntasCertificados()->attach($pergunta->id, ['certificadovod_id' => $pergunta->certificado->id]);
            }
            $aluno->refresh();
        }
    }

    public static function getPergunta(Aluno $aluno, Certificadovod $certificado)
    {
        return $aluno->perguntasCertificados()->wherePivot('certificadovod_id', $certificado->id)->wherePivot('resposta', 0)->first();
    }

    public static function responderPerguntaCertificado(Aluno $aluno, Certificadovod $certificado, Perguntacertificadovod $pergunta, RespostaRequest $request)
    {
        $aluno->perguntasCertificados()->updateExistingPivot($pergunta->id, ['resposta' => $request->resposta]);

        return self::getPergunta($aluno, $certificado);
    }

    public static function getPerguntasCorrecao(Aluno $aluno, Certificadovod $certificado)
    {
        return $aluno->perguntasCertificados()->wherePivot('certificadovod_id', $certificado->id)->get();
    }

    public static function getPerguntasCorretas(Aluno $aluno, Certificadovod $certificado)
    {
        $perguntas = self::getPerguntasCorrecao($aluno, $certificado);
        $corretas = 0;
        foreach ($perguntas as $p) {
            if ($p->correta == $p->pivot->resposta) {
                $corretas++;
            }
        }

        return $corretas;
    }

    public static function refazPerguntas(Aluno $aluno, Certificadovod $certificado)
    {
        foreach ($certificado->perguntas->where('certificadovod_id', $certificado->id) as $pergunta) {
            $aluno->perguntasCertificados()->updateExistingPivot($pergunta->id, ['resposta' => 0]);
        }
        $aluno->refresh();
    }

    public static function gerarCertificado(Aluno $aluno, Certificadovod $certificado)
    {
        $aluno->certificados()->updateExistingPivot($certificado->id, ['concluido' => 1]);

        return self::gerarCertificadoFisico($aluno, $certificado);
    }

    public static function gerarCertificadoFisico(Aluno $aluno, Certificadovod $certificado)
    {
        $im = imagecreatefrompng(assets('sistema/images/certificado.png'));
        if ($im) {
            $white = imagecolorallocate($im, 53, 75, 47);
            $width = imagesx($im);
            $height = imagesy($im);
            $font = resource_path() . '/assets/sistema/alunos/fonts/Nickainley-Normal.otf';
            $fontSize = 50;
            $angle = 0;

            $dimensions = imagettfbbox($fontSize, $angle, $font, $aluno->fullName);
            $textWidth = abs($dimensions[4] - $dimensions[0]);
            $leftTextPos = ($width - $textWidth) / 2;
            imagettftext($im, $fontSize, $angle, $leftTextPos + 1, 790, $white, $font, $aluno->fullName);

            if ($certificado->modulo()->exists()) {
                $curso = $certificado->curso->titulo . ' / ' . $certificado->modulo->titulo;
            } else {
                $curso = $certificado->curso->titulo;
            }
            $dimensions_modulo = imagettfbbox($fontSize, $angle, $font, $curso);
            $textWidth_modulo = abs($dimensions_modulo[4] - $dimensions_modulo[0]);
            $leftTextPos_modulo = ($width - $textWidth_modulo) / 2;
            imagettftext($im, $fontSize, $angle, $leftTextPos_modulo + 1, 940, $white, $font, $curso);

            $dimensions_data = imagettfbbox(33, $angle, $font, Carbon::now()->format('d/m/Y'));
            $textWidth_data = abs($dimensions_data[4] - $dimensions_data[0]);
            $leftTextPos_data = ($width - $textWidth_data) / 2;
            imagettftext($im, 33, $angle, $leftTextPos_data + 1, 1050, $white, $font, Carbon::now()->format('d/m/Y'));

            $dimensions = imagettfbbox($fontSize, $angle, $font, '');
            $textWidth = abs($dimensions[4] - $dimensions[0]);
            $leftTextPos = ($width - $textWidth) / 2;
            imagettftext($im, 13, $angle, $leftTextPos + 4, 41, $white, $font, '');

            imagealphablending($im, false);
            imagesavealpha($im, true);
            $path = '/aluno/' . $aluno->id . '/certificados/';
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
            $path = storage_path() . '/app/public/aluno/' . $aluno->id . '/certificados/' . limpaEspacos($curso) . '.png';
            if (imagepng($im, $path)) {
                $cert = url('public/storage/aluno/' . $aluno->id . '/certificados/' . limpaEspacos($curso) . '.png');

                return url($cert);
            }

            return false;
        }
    }

    public static function getCertificado(Aluno $aluno, Certificadovod $certificado)
    {
        if ($certificado->modulo()->exists()) {
            $curso = $certificado->curso->titulo . ' / ' . $certificado->modulo->titulo;
        } else {
            $curso = $certificado->curso->titulo;
        }
        $cert = url('public/storage/aluno/' . $aluno->id . '/certificados/' . limpaEspacos($curso) . '.png');

        return url($cert);
    }

    public static function adicionaPreferido(Aluno $aluno, Cursovod $curso)
    {
        $aluno->cursos()->updateExistingPivot($curso->id, ['preferido' => 1]);
    }

    public static function removePreferido(Aluno $aluno, Cursovod $curso)
    {
        $aluno->cursos()->updateExistingPivot($curso->id, ['preferido' => 0]);
    }

    public static function adicionaAulaPreferida(Aluno $aluno, Modulovod $modulo, Aulavod $aula)
    {
        $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->updateExistingPivot($aula->id, ['preferida' => 1]);
    }

    public static function removeAulaPreferida(Aluno $aluno, Modulovod $modulo, Aulavod $aula)
    {
        $aluno->aulas()->wherePivot('modulovod_id', $modulo->id)->updateExistingPivot($aula->id, ['preferida' => 0]);
    }

    public static function cancelaAssinatura(Aluno $aluno)
    {
        MoipRepository::cancelarAssinatura($aluno);
        $aluno->validade_assinatura = null;
        $gratuito = BaseRepository::get('plano', ['gratuito' => 1])->first();
        $aluno->plano_id = $gratuito->id;
        $aluno->status_pedido = 2;
        $aluno->notify(new SuspendeAssinaturaNotification());
        $aluno->save();
    }

    public static function cancelaAssinaturaParaNova(Aluno $aluno)
    {
        MoipRepository::cancelarAssinatura($aluno);
        $aluno->validade_assinatura = null;
        $aluno->save();
    }

    public static function trocaAssinatura(Aluno $aluno, Plano $plano, Bool $pedido = true)
    {
        $aluno->plano_id = $plano->id;
        if ($pedido == true) {
            $aluno->status_pedido = 0;
        }
        $aluno->save();
        // $aluno->notify(new AlteraAssinaturaNotification());
        $aluno->refresh();
    }

    public static function alteraAssinatura(Aluno $aluno, Int $tipo, FormRequest $request)
    {
        return MoipRepository::alteraAssinatura($aluno, $request, $tipo);
    }

    public static function alteraPlanoAssinatura(Aluno $aluno, Plano $plano)
    {
        return MoipRepository::alteraPlanoAssinatura($aluno, $plano);
    }

    public static function agenda(Professoraovivo $professor, Request $request)
    {
        if (!Session('cart')) {
            session(['cart' => []]);
        }
        if ($request->aulaaovivo_id) {
            $aula = BaseRepository::find('aulaaovivo', $request->aulaaovivo_id);
            if (!ProfessorRepository::checkAula($professor, $aula)) {
                return false;
            }
            $request->session()->put('cart.' . $aula->id, ['p' => false, $request->qtd ?? 1 => $aula->valor]);
        } else {
            if ($request->t == 'a') {
                $aula = BaseRepository::find('aulaaovivo', $request->o);
                if (!ProfessorRepository::checkAula($professor, $aula)) {
                    return false;
                }
                $total = $aula->valor;
                if (session('cupom')) {
                    if (array_key_exists($request->o, session('cupom'))) {
                        $cupom = BaseRepository::get('cupomaovivo', ['slug' => session('cupom')[$request->o]])->first();
                        $desconto = $cupom->desconto;
                        $valor = $aula->valor;
                        $total = currencyToAppDot($valor - (($valor / 100) * $desconto));
                    }
                }
                $request->session()->put('cart.' . $aula->id, ['p' => false, $request->qtd ?? 1 => $total]);
            }
            if ($request->t == 'p') {
                $pacote = BaseRepository::find('pacoteaulaaovivo', $request->o);
                $aula = $pacote->aula;
                if (!ProfessorRepository::checkAula($professor, $aula)) {
                    return false;
                }
                $request->session()->forget('cart.' . $aula->id);
                $request->session()->forget('cupom.' . $aula->id);
                $total = $aula->valor * $pacote->quantidade;
                $valor = ($total - (($total / 100) * $pacote->desconto));
                $request->session()->put('cart.' . $aula->id, ['p' => $request->o, 1 => $valor]);
            }
        }
    }

    public static function getCart()
    {
        $aulas = [];
        foreach (session('cart') as $c => $i) {
            $pacote = $i['p'];
            foreach ($i as $k => $v) {
                if ($k != 'p') {
                    $aula = BaseRepository::find('aulaaovivo', $c);
                    $aula->quantidade = $k;
                    $aula->pacote = $pacote;
                    $aula->total = $v;
                    $aulas[] = $aula;
                }
            }
        }

        return new Collection($aulas);
    }

    public static function removeCart(Aulaaovivo $aula, Request $request)
    {
        $request->session()->forget('cart.' . $aula->id);
        $request->session()->forget('cupom.' . $aula->id);
    }

    public static function checkCupom(CupomCheckout $request)
    {
        // pre(session('cupom'));
        $cupom = BaseRepository::get('cupomaovivo', ['slug' => $request->cupom])->first();
        if (!Session('cupom')) {
            session(['cupom' => []]);
        }
        if (array_key_exists($cupom->aulaaovivo_id, session('cupom'))) {
            return false;
        }
        if (($cupom->validade . ' 23:59:59') > Carbon::now()) {
            if (array_key_exists($cupom->aulaaovivo_id, session('cart'))) {
                $desconto = $cupom->desconto;
                $item = session('cart')[$cupom->aulaaovivo_id];
                $keys = array_keys($item);
                $valor = $item[$keys[1]];
                $total = currencyToAppDot($valor - (($valor / 100) * $desconto));
                $request->session()->put('cart.' . $cupom->aulaaovivo_id, ['p' => $item[$keys[0]], $keys[1] => $total]);
                $request->session()->put('cupom.' . $cupom->aulaaovivo_id, $request->cupom);
                return true;
            }
        } else {
            return false;
        }
    }

    public static function criaAgendamentos(Pedidoaovivo $pedido)
    {
        $configs = BaseRepository::find('configuracoes', 1);
        $fixo = (float) $configs->valor_fixo;
        $taxa = (float) $configs->comissao_abaixo;
        foreach ($pedido->items as $item) {
            if ($item->pacoteaulaaovivo_id == null) {
                for ($x = 0; $x < $item->quantidade; $x++) {
                    $comissao = currencyToAppDot(($item->valor_unitario / 100) * $taxa);
                    $valor_professor = ($item->valor_unitario - $comissao) - $fixo;
                    // pre($valor_professor);
                    Agendamentoaovivo::create([
                        'aluno_id' => $pedido->aluno->id,
                        'aulaaovivo_id' => $item->aula->id,
                        'professoraovivo_id' => $item->aula->professor->id,
                        'valor_aula' => $item->valor_unitario,
                        'valor_professor' => currencyToAppDot($valor_professor),
                    ]);
                }
            } else {
                $pacote = BaseRepository::find('pacoteaulaaovivo', $item->pacoteaulaaovivo_id);
                for ($x = 0; $x < $pacote->quantidade; $x++) {
                    $aula = $item->aula->valor - (($item->aula->valor * $pacote->desconto) / 100);
                    $comissao = currencyToAppDot(($aula / 100) * $taxa);
                    $valor_professor = (($aula - $comissao) - $fixo);
                    Agendamentoaovivo::create([
                        'aluno_id' => $pedido->aluno->id,
                        'aulaaovivo_id' => $pacote->aula->id,
                        'professoraovivo_id' => $item->aula->professor->id,
                        'valor_aula' => $aula,
                        'valor_professor' => currencyToAppDot($valor_professor),
                    ]);
                }
            }
        }
    }

    public static function preAgenda(Request $request)
    {
        $ini = Carbon::createFromFormat('D M d Y H:i:s e+', $request->s)->format('H:i');
        $fim = Carbon::createFromFormat('D M d Y H:i:s e+', $request->e)->format('H:i');
        $aula = BaseRepository::find('aulaaovivo', $request->a);
        $resp = [
            'date' => Carbon::createFromFormat('D M d Y H:i:s e+', $request->s)->format('d/m/Y'),
            'start' => $ini,
            'end' => $fim,
            'id' => $aula->id,
            'c' => $aula->categoria->nome,
            'p' => $aula->professor->fullName,
        ];

        return $resp;
    }

    public static function agendar(Request $request)
    {
        $agenda = BaseRepository::find('agendamentoaovivo', $request->ag);
        $agenda->data = dateAppToBd($request->d);
        $agenda->inicio = $request->s;
        $agenda->fim = $request->e;
        $agenda->save();
        $agenda->refresh();

        return $agenda;
    }

    public static function adicionaHistorico(Aluno $aluno)
    {
        $h = new Historicoaluno();
        $h->aluno_id = $aluno->id;
        $h->status = 0;
        if ($aluno->status_pedido != 0) {
            $h->status = $aluno->status_pedido;
        }
        $h->plano_id = $aluno->plano_id;
        $h->forma = $aluno->forma_pagamento;
        $h->validade = $aluno->validade_assinatura;
        $h->valor = $aluno->plano->valor;
        $h->save();
    }

    public static function getPlanos(Aluno $aluno)
    {
        if ($aluno->pais == 1) {
            return BaseRepository::order('plano')->where('exibir', 1);
        }
        if ($aluno->pais == 2) {
            return BaseRepository::order('plano')->where('plano_id_paypal', '!=', null)->where('exibir', 1);
        }
    }

    public static function updateRememberToken(Aluno $aluno)
    {
        $new = Str::random(60);
        $aluno->remember_token = $new;
        $aluno->save();
    }

    public static function criaAvaliacao(Agendamentoaovivo $agendamento)
    {
        Avaliacaoaovivo::create([
            'agendamentoaovivo_id' => $agendamento->id,
            'aluno_id' => $agendamento->aluno->id,
            'professoraovivo_id' => $agendamento->professor->id,
        ]);
    }

    public static function avaliar(Avaliacaoaovivo $avaliacao, AvaliacaoRequest $request)
    {
        $avaliacao->ocorreu = $request->ocorreu;
        $avaliacao->rate_professor = $request->rate_professor;
        $avaliacao->comentario_aluno = $request->comentario_aluno;
        $avaliacao->save();
        ProfessorRepository::avaliacao($avaliacao, $request);
    }

    public static function checkAutor(String $model, Int $id, Aluno $aluno)
    {
        $r = BaseRepository::find($model, $id);

        return $r->aluno_id === $aluno->id;
    }

    public static function reagendaAula(Agendamentoaovivo $a)
    {
        $a->professor->notify((new AulaReAgendadaProfessor($a)));
        $a->data = null;
        $a->inicio = null;
        $a->fim = null;
        $a->meeting = null;
        $a->status = 0;
        $a->save();
    }

    public static function checkLIcencas(Request $request)
    {
        $licencas = BaseRepository::find('configuracoes', 1)->licencas_zoom;
        $inicio = Carbon::createFromDate(dateAppToBd($request->d) . ' ' . $request->s);
        $fim = Carbon::createFromDate(dateAppToBd($request->d) . ' ' . $request->e);
        $aulas = Agendamentoaovivo::where('data', dateAppToBd($request->d))->get();
        $count = 0;
        if ($aulas->count() > 0) {
            foreach ($aulas as $a) {
                $ai = Carbon::createFromDate($a->data . ' ' . $a->inicio);
                $af = Carbon::createFromDate($a->data . ' ' . $a->fim);
                if ($inicio->between($ai, $af, true) || $fim->between($ai, $af, true)) {
                    $count++;
                }
            }
        }

        return $count >= $licencas;
    }

    public static function salvaRelatorio(Request $request)
    {
        $r = new Semlicenca();
        $a = BaseRepository::find('agendamentoaovivo', $request->ag);
        $r->aluno_id = $a->aluno_id;
        $r->professoraovivo_id = $a->professoraovivo_id;
        $r->aulaaovivo_id = $a->aulaaovivo_id;
        $r->data = dateAppToBd($request->d);
        $r->hora = $request->s;
        $r->save();
        self::notificaLicenca($r);
    }

    public static function notificaLicenca(Semlicenca $n)
    {
        User::all()->each(function ($u) use ($n) {
            $u->notify(new SemLicencaNotification($n));
        });
    }
}
