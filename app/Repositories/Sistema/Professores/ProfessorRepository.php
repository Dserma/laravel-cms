<?php

namespace App\Repositories\Sistema\Professores;

use Carbon\Carbon;
use App\Models\Aluno;
use App\Models\Aulaaovivo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Avaliacaoaovivo;
use App\Models\Categoriaaovivo;
use App\Models\Professoraovivo;
use App\Models\Agendamentoaovivo;
use MailchimpMarketing\ApiClient;
use App\Models\Imagemprofessoraovivo;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\ClientException;
use App\Repositories\Sistema\BaseRepository;
use App\Notifications\Aovivo\CadastroProfessor;
use App\Notifications\Sistema\Aovivo\AulaReAgendada;
use App\Http\Requests\Sistema\Alunos\AvaliacaoRequest;
use App\Http\Requests\Sistema\Cadastro\CadastroProfessorRequest;

class ProfessorRepository
{
    public static function cadastra(CadastroProfessorRequest $request)
    {
        $professor = BaseRepository::adicionar('professoraovivo', $request);
        $professor->notify(new CadastroProfessor());
        self::mailChimp($professor);

        return $professor;
    }

    public static function mailChimp(Professoraovivo $professor)
    {
        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('app.mailchimp.key'),
            'server' => config('app.mailchimp.server'),
        ]);

        $list_id = config('app.mailchimp.listId');

        try {
            $response = $mailchimp->lists->addListMember($list_id, [
                'email_address' => $professor->email,
                'status' => 'subscribed',
                'tags' => ['professor'],
                'merge_fields' => [
                    'FNAME' => $professor->nome,
                    'LNAME' => $professor->sobrenome,
                ],
            ]);
        } catch (ClientException $e) {
        }
    }

    public static function checkCategorias(Professoraovivo $professor)
    {
        return $professor->categorias()->exists();
    }

    public static function checkDisponibilidade(Professoraovivo $professor)
    {
        return $professor->disponibilidades()->exists();
    }

    public static function aulasPacote(Professoraovivo $professor)
    {
        $lista = [];
        foreach ($professor->aulas as $aula) {
            $lista[$aula->id] = $aula->categoria->nome . ' - ' . $aula->duracao . ' minutos - ' . currencyToApp($aula->valor);
        }

        return $lista;
    }

    public static function nomeAula(Aulaaovivo $aula)
    {
        return $aula->categoria->nome . ' - ' . $aula->duracao . ' minutos - ' . currencyToApp($aula->valor);
    }

    public static function uploadImagens(Professoraovivo $professor, Request $request)
    {
        foreach ($request->all() as $k => $v) {
            if ($v instanceof \Illuminate\Http\UploadedFile) {
                $field = $k;
            }
        }
        $nameFile = null;
        if ($request->hasFile('galeria') && $request->file('galeria')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->galeria->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->galeria->storeAs('professoraovivo/' . $professor->id . '/', $nameFile);
            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
            }
            ['link' => url('storage/app/public/professoraovivo/') . $professor->id . '/' . $nameFile];
            $imagem = new Imagemprofessoraovivo();
            $imagem->imagem = $nameFile;
            $professor->imagens()->save($imagem);

            return response()->json(['ok'], 200);
        }
    }

    public static function apagarImagens(Professoraovivo $professor, Request $request)
    {
        $dir = 'professoraovivo/' . $professor->id;
        $imagem = Imagemprofessoraovivo::find($request->key);
        $arquivo = $dir . '/' . $imagem->imagem;
        Storage::delete($arquivo);
        $imagem->delete();
        $data = [];

        return response()->json($data);
    }

    public static function getProfessores(Request $request, Categoriaaovivo $categoria = null)
    {
        if ($categoria == null && !isset($request)) {
            return Professoraovivo::where('status', 1)->get();
        }

        if ($categoria != null) {
            return $categoria->professores->where('status', 1);
        }

        if (isset($request)) {
            $items = Professoraovivo::whereHas('aulas')->where('status', 1)
                ->when($request->professor != null, function ($q) use ($request) {
                    return $q->where('nome', 'like', '%' . $request->professor . '%')
                        ->orWhere('sobrenome', 'like', '%' . $request->professor . '%');
                })
                ->when($request->disponibilidade != null, function ($q) use ($request) {
                    return $q->whereHas('disponibilidades', function ($query) use ($request) {
                        return $query->where('dias', 'LIKE', '%' . implode(',', $request->disponibilidade) . '%');
                    });
                })
                ->when($request->min != null, function ($q) use ($request) {
                    return $q->whereHas('aulas', function ($query) use ($request) {
                        return $query->where('valor', '>=', currencyToBd($request->min));
                    });
                })
                ->when($request->max != null, function ($q) use ($request) {
                    return $q->whereHas('aulas', function ($query) use ($request) {
                        return $query->where('valor', '<=', $request->max);
                    });
                })->get();

            // pre($items);

            return $items;
        }
    }

    public static function getCategorias(Professoraovivo $professor)
    {
        $array = [];
        foreach ($professor->categorias as $c) {
            if ($c->aulas()->exists()) {
                $array[$c->id] = $c->nome;
            }
        }

        return $array;
    }

    public static function getAulas(Professoraovivo $professor, Request $request)
    {
        return $professor->aulas->where('categoriaaovivo_id', $request->c);
    }

    public static function checkAula(Professoraovivo $professor, Aulaaovivo $aula)
    {
        return $professor->id === $aula->professor->id;
    }

    public static function disponibilidade(Agendamentoaovivo $agendamento, Professoraovivo $professor, Aulaaovivo $aula, Aluno $aluno)
    {
        $ap = Agendamentoaovivo::where('professoraovivo_id', $professor->id)->where('data', '>', Carbon::now()->format('Y-m-d'))->get();
        $aap = [];
        if ($ap->count() > 0) {
            foreach ($ap as $a) {
                $aap[$a->data]['i'][] = $a->inicio;
                $aap[$a->data]['f'][] = $a->fim;
            }
        }
        $aa = Agendamentoaovivo::where('aluno_id', $agendamento->aluno->id)->where('data', '>', Carbon::now()->format('Y-m-d'))->get();
        $aaa = [];
        if ($aa->count() > 0) {
            foreach ($aa as $b) {
                $aaa[$b->data]['i'][] = $b->inicio;
                $aaa[$b->data]['f'][] = $b->fim;
            }
        }
        $at = array_merge($aap, $aaa);
        // pre($at);
        $disponibilidades = $professor->disponibilidades;
        $result = [];
        foreach ($disponibilidades as $d) {
            if ($d->aluno_id != null && ($d->aluno_id != $aluno->id)) {
                continue;
            }
            $dias = explode(',', $d->dias);
            // $inicio = Carbon::createFromDate($d->inicio . ' ' . $d->hora_inicio);
            $fim = Carbon::createFromDate($d->fim . ' ' . $d->hora_fim);
            $hini = explode(':', $d->hora_inicio);
            $hfim = explode(':', $d->hora_fim);
            // if ($inicio->lessThan(Carbon::now()->addDays)) {
            $inicio = Carbon::now()->addDays(2);
            // $inicio->setTime($hini[0], $hini[1], $hini[2]);
            // }
            $hinicio = Carbon::createFromTime($hini[0], $hini[1], $hini[2]);
            $hfinal = Carbon::createFromTime($hfim[0], $hfim[1], $hfim[2]);
            $hdif = $hfinal->diffInMinutes($hinicio);
            $duracao = $aula->duracao;
            $qtd = currencyToAppNoDecimals($hdif / $duracao);
            $diff = $fim->diffInDays($inicio);
            for ($x = 1; $x <= $diff; $x++) {
                $dia = $x == 1 ? $inicio : $inicio->addDays();
                $fimDia = Carbon::createFromFormat('Y-m-d H:i:s', $dia->format('Y-m-d') . ' ' . $hfim[0] . ':' . $hfim[1] . ':' . $hfim[2]);
                $ds = $dia->dayOfWeek;
                $tem = array_search($ds, $dias);
                if (false !== $tem) {
                    $dia->setTime($hini[0], $hini[1], $hini[2]);
                    for ($i = 0; $i < $qtd; $i++) {
                        $mostrar = 1;
                        if ($i == 0) {
                            $cHi = Carbon::createFromFormat('Y-m-d H:i:s', $dia->format('Y-m-d H:i:s'))->addSeconds(10);
                            $cHf = Carbon::createFromFormat('Y-m-d H:i:s', $dia->addMinutes($duracao)->format('Y-m-d H:i:s'))->subSeconds(10);
                        } else {
                            $cHi = Carbon::createFromFormat('Y-m-d H:i:s', $dia->format('Y-m-d H:i:s'))->addMinutes(5)->addSeconds(10);
                            $cHf = Carbon::createFromFormat('Y-m-d H:i:s', $dia->addMinutes($duracao + 5)->format('Y-m-d H:i:s'))->subSeconds(10);
                        }
                        if ($cHi->greaterThan($fimDia)) {
                            continue;
                        }
                        if (isset($at[$dia->format('Y-m-d')])) {
                            for ($z = 0; $z < count($at[$dia->format('Y-m-d')]['i']); $z++) {
                                $hi = Carbon::createFromFormat('Y-m-d H:i:s', $cHi->format('Y-m-d') . $at[$cHi->format('Y-m-d')]['i'][$z]);
                                $hf = Carbon::createFromFormat('Y-m-d H:i:s', $cHf->format('Y-m-d') . $at[$cHf->format('Y-m-d')]['f'][$z]);
                                if ($cHi->between($hi, $hf, true) || $cHf->between($hi, $hf, true)) {
                                    $mostrar = 0;
                                }
                            }
                        }
                        if ($mostrar == 1) {
                            $result[] = [
                                'start' => $cHi->subSeconds(10)->format('Y-m-d\TH:i:s.u'),
                                'end' => $cHf->addSeconds(10)->format('Y-m-d\TH:i:s.u'),
                                'allDay' => false,
                                'backgroundColor' => '#fff',
                                'borderColor' => '#fff',
                                'displayEventEnd' => true,
                                'classNames' => 'agendar',
                                'extendedProps' => [
                                    'ag' => $agendamento->id,
                                    'a' => $aula->id,
                                ],
                            ];
                        }
                    }
                }
            }
        }

        // pre($mostrar);

        return $result;
    }

    public static function previaAgenda(Professoraovivo $professor)
    {
        $ap = Agendamentoaovivo::where('professoraovivo_id', $professor->id)->where('data', '>', Carbon::now()->format('Y-m-d'))->get();
        $aap = [];
        if ($ap->count() > 0) {
            foreach ($ap as $a) {
                $aap[$a->data]['i'][] = $a->inicio;
                $aap[$a->data]['f'][] = $a->fim;
            }
        }
        $at = $aap;
        $aula = $professor->aulas->sortByDesc('duracao')->first();
        $disponibilidades = $professor->disponibilidades;
        $result = [];
        foreach ($disponibilidades as $d) {
            $dias = explode(',', $d->dias);
            $fim = Carbon::createFromDate($d->fim . ' ' . $d->hora_fim);
            $hini = explode(':', $d->hora_inicio);
            $hfim = explode(':', $d->hora_fim);
            $inicio = Carbon::now()->addDays(2);
            $hinicio = Carbon::createFromTime($hini[0], $hini[1], $hini[2]);
            $hfinal = Carbon::createFromTime($hfim[0], $hfim[1], $hfim[2]);
            $hdif = $hfinal->diffInMinutes($hinicio);
            $duracao = $aula->duracao;
            $qtd = currencyToAppNoDecimals($hdif / $duracao);
            $diff = $fim->diffInDays($inicio);
            for ($x = 1; $x <= $diff; $x++) {
                $dia = $x == 1 ? $inicio : $inicio->addDays();
                $ds = $dia->dayOfWeek;
                $tem = array_search($ds, $dias);
                if (false !== $tem) {
                    $dia->setTime($hini[0], $hini[1], $hini[2]);
                    for ($i = 0; $i < $qtd; $i++) {
                        $mostrar = 1;
                        if ($i == 0) {
                            $cHi = Carbon::createFromFormat('Y-m-d H:i:s', $dia->format('Y-m-d H:i:s'))->addSeconds(10);
                            $cHf = Carbon::createFromFormat('Y-m-d H:i:s', $dia->addMinutes($duracao)->format('Y-m-d H:i:s'))->subSeconds(10);
                        } else {
                            $cHi = Carbon::createFromFormat('Y-m-d H:i:s', $dia->format('Y-m-d H:i:s'))->addMinutes(5)->addSeconds(10);
                            $cHf = Carbon::createFromFormat('Y-m-d H:i:s', $dia->addMinutes($duracao + 5)->format('Y-m-d H:i:s'))->subSeconds(10);
                        }
                        if (isset($at[$dia->format('Y-m-d')])) {
                            for ($z = 0; $z < count($at[$dia->format('Y-m-d')]['i']); $z++) {
                                $hi = Carbon::createFromFormat('Y-m-d H:i:s', $cHi->format('Y-m-d') . $at[$cHi->format('Y-m-d')]['i'][$z]);
                                $hf = Carbon::createFromFormat('Y-m-d H:i:s', $cHf->format('Y-m-d') . $at[$cHf->format('Y-m-d')]['f'][$z]);
                                if ($cHi->between($hi, $hf, true) || $cHf->between($hi, $hf, true)) {
                                    $mostrar = 1;
                                }
                            }
                        }
                        if ($mostrar == 1) {
                            $result[] = [
                                'start' => $cHi->subSeconds(10)->format('Y-m-d\TH:i:s.u'),
                                'end' => $cHf->addSeconds(10)->format('Y-m-d\TH:i:s.u'),
                                'allDay' => false,
                                'backgroundColor' => '#fff',
                                'borderColor' => '#fff',
                                'displayEventEnd' => false,
                                'classNames' => 'previa',
                            ];
                        } else {
                            $result[] = [
                                'start' => $cHi->format('Y-m-d\TH:i:s.u'),
                                'end' => $cHf->format('Y-m-d\TH:i:s.u'),
                                'allDay' => false,
                                'displayEventTime' => false,
                                'backgroundColor' => '#fff',
                                'borderColor' => '#fff',
                                'textColor' => '#fff',
                                'classNames' => 'noshow',
                                'displayEventEnd' => true,
                                'extendedProps' => [
                                    'a' => false,
                                ],
                            ];
                        }
                    }
                }
            }
        }

        return $result;
    }

    public static function agendar(Request $request)
    {
        $agendaAluno = BaseRepository::find('agendamentoaovivo', $request->ag);
    }

    public static function avaliacao(Avaliacaoaovivo $avaliacao, AvaliacaoRequest $request)
    {
        $agendamento = BaseRepository::find('agendamentoaovivo', $avaliacao->agendamento->id);
        if ($request->ocorreu == 1) {
            $agendamento->status = 3;
            $agendamento->liberacao_aluno = now();
            $agendamento->save();
        }
        if ($request->ocorreu == 2) {
            $agendamento->status = 4;
            $agendamento->save();
        }

        $agendamento->refresh();

        self::atualizaAvaliacao($avaliacao->professor);
    }

    public static function atualizaAvaliacao(Professoraovivo $professor)
    {
        $avs = BaseRepository::get('avaliacaoaovivo', ['professoraovivo_id' => $professor->id, 'ocorreu' => 1]);
        $total = $avs->sum('rate_professor') > 1 ? $avs->sum('rate_professor') : 1;
        $divisor = $avs->count() > 1 ? $avs->count() : 1;
        $rate = $total / $divisor;
        $professor->avaliacao = $rate;
        $professor->save();
    }

    public static function encerraDisputa(Avaliacaoaovivo $avaliacao)
    {
        $avaliacao->agendamento->status = 6;
        $avaliacao->agendamento->liberacao_aluno = date('Y-m-d');
        $avaliacao->agendamento->save();
    }

    public static function reagendaAula(Avaliacaoaovivo $avaliacao)
    {
        $a = $avaliacao->agendamento;
        $a->data = null;
        $a->inicio = null;
        $a->fim = null;
        $a->meeting = null;
        $a->status = 5;
        $a->save();
        $avaliacao->ocorreu = 3;
        $avaliacao->save();
    }

    public static function reagendaAulaSemAvaliacao(Agendamentoaovivo $a)
    {
        $a->aluno->notify((new AulaReAgendada($a)));
        $a->data = null;
        $a->inicio = null;
        $a->fim = null;
        $a->meeting = null;
        $a->status = 5;
        $a->save();
    }

    public static function remove(Avaliacaoaovivo $avaliacao)
    {
        $avaliacao->exibir = 0;
        $avaliacao->save();
    }

    public static function liberado(Professoraovivo $professor)
    {
        return self::getLiberado($professor)->sum('valor_professor');
    }

    public static function pendente(Professoraovivo $professor)
    {
        return self::getPendente($professor)->sum('valor_professor');
    }

    public static function naoRealizadas(Professoraovivo $professor)
    {
        return self::getNaoRealizadas($professor)->sum('valor_professor');
    }

    public static function bloqueado(Professoraovivo $professor)
    {
        return self::getBloqueado($professor)->sum('valor_professor');
    }

    public static function getLiberado(Professoraovivo $professor)
    {
        return Agendamentoaovivo::where('professoraovivo_id', $professor->id)->whereIn('status', [3, 6])->whereIn('status_pagamento', [0, 6])->where('liberacao_aluno', '<', Carbon::now()->subDays(30));
    }

    public static function getPendente(Professoraovivo $professor)
    {
        return Agendamentoaovivo::where('professoraovivo_id', $professor->id)->whereIn('status', [2, 3, 6])->where('status_pagamento', 0)->where('liberacao_aluno', '>', Carbon::now()->subDays(30));
    }

    public static function getNaoRealizadas(Professoraovivo $professor)
    {
        return Agendamentoaovivo::where('professoraovivo_id', $professor->id)->whereIn('status', [0, 1, 5])->where('status_pagamento', 0);
    }

    public static function getBloqueado(Professoraovivo $professor)
    {
        return Agendamentoaovivo::where('professoraovivo_id', $professor->id)->where('status', 4)->where('status_pagamento', 0);
    }

    public static function transferencia(Professoraovivo $professor)
    {
        $registros = BaseRepository::get('agendamentoaovivo', ['professoraovivo_id' => $professor->id, 'status' => 3, 'status_pagamento' => 0])->where('liberacao_aluno', '<', Carbon::now()->subDays(6));
        foreach ($registros as $r) {
            $r->data_saque = now();
            $r->status_pagamento = 1;
            $r->save();
        }
    }

    public static function checkAutor(String $model, Int $id, Professoraovivo $professor)
    {
        $r = BaseRepository::find($model, $id);

        return $r->professoraovivo_id === $professor->id;
    }

    public static function alteraFinanceiro(Professoraovivo $professor)
    {
        $professor->alterou_conta = 0;
        $professor->tipo_conta = $professor->tipo_conta_tmp;
        $professor->banco = $professor->banco_tmp;
        $professor->agencia = $professor->agencia_tmp;
        $professor->agencia_digito = $professor->agencia_digito_tmp;
        $professor->conta = $professor->conta_tmp;
        $professor->digito = $professor->digito_tmp;
        $professor->save();
        self::zeraTmp($professor);
    }

    public static function zeraTmp(Professoraovivo $professor)
    {
        $professor->tipo_conta_tmp = null;
        $professor->banco_tmp = null;
        $professor->agencia_tmp = null;
        $professor->agencia_digito_tmp = null;
        $professor->conta_tmp = null;
        $professor->digito_tmp = null;
        $professor->token_alteracao = Str::random(100);
        $professor->save();
    }

    public static function alunosAtivos(Professoraovivo $professor)
    {
        $array = [];
        foreach ($professor->agendamentos as $a) {
            $array[$a->aluno->id] = $a->aluno->fullName;
        }

        return $array;
    }

    public static function updateRememberToken(Professoraovivo $professor)
    {
        $new = Str::random(60);
        $professor->remember_token = $new;
        $professor->save();
    }
}
