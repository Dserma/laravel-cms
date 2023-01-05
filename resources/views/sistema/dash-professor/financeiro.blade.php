@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_finances">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-hand-holding-usd"></i> Informações
                        Financeiras
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT HEADER -->

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h5 class="m-0 text-danger text-bold"><i class="far fa-question-mark-circle"></i> Instruções Financeiras</h5>
                    </div>
                    <div class="card-body text-black text-14-pt line-24 regular">
                        {!! $informacoes->conteudo !!}
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0 text-danger text-bold"><i class="fas fa-hand-holding-usd"></i> Informações
                                Financeiras</h5>
                        </div>
                        <div class="card-body">
                            <div class="col-12 text-red text-14-pt bold">
                                O saldo disponível para resgate é o valor somado das aulas que foram confirmadas pelos alunos como REALIZADAS, a mais de 30 dias.
                            </div>
                            <ul class="list-group margin-top-10">
                                <li class="list-group-item border rounded text-danger mb-3">
                                    <a class="text-danger" @if( $resgate > 0 )data-fancybox @endif data-type="iframe" data-src="{{ route('sistema.dash-professor.detalhes', [$usuario->id, 0]) }}" href="javascript:;">
                                        <div class="row justify-content-between align-items-center text-center text-md-left">
                                            <div class="col-12 col-md-auto">
                                                <div class="d-flex align-content-center">
                                                    <div>Disponível para resgate</div>
                                                    <button type="button" data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="right"
                                                            data-title = "Disponíveis para resgate"
                                                            data-content="Valores de aulas confirmadas a mais de 30 dias.">
                                                        <i class="fas fa-question-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-auto text-bold">{{ currencyToApp($resgate) }}</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item border rounded text-danger mb-3">
                                    <a class="text-danger" @if( $realizadas > 0 )data-fancybox @endif data-type="iframe" data-src="{{ route('sistema.dash-professor.detalhes', [$usuario->id, 1]) }}" href="javascript:;">
                                        <div class="row justify-content-between align-items-center text-center text-md-left">
                                            <div class="col-12 col-md-auto">
                                                <div class="d-flex align-content-center">
                                                    <div>Aulas já realizadas, a menos de 30 dias</div>
                                                    <button type="button" data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="right"
                                                            data-title = "Já realizadas, a menos de 30 dias"
                                                            data-content="Valores de aulas já avaliadas e liberadas, a menos de 30 dias">
                                                        <i class="fas fa-question-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-auto text-bold">{{ currencyToApp($realizadas) }}</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item border rounded text-danger mb-3">
                                    <a class="text-danger" @if( $naoRealizadas > 0 )data-fancybox @endif data-type="iframe" data-src="{{ route('sistema.dash-professor.detalhes', [$usuario->id, 2]) }}" href="javascript:;">
                                        <div class="row justify-content-between align-items-center text-center text-md-left">
                                            <div class="col-12 col-md-auto">
                                                <div class="d-flex align-content-center">
                                                    <div>Aulas ainda não realizadas</div>
                                                    <button type="button" data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="right"
                                                            data-title = "Não realizadas"
                                                            data-content="Valores de aulas ainda não realizadas">
                                                        <i class="fas fa-question-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-auto text-bold">{{ currencyToApp($naoRealizadas) }}</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item border rounded text-danger mb-3">
                                    <a class="text-danger" @if( $bloqueado > 0 )data-fancybox @endif data-type="iframe" data-src="{{ route('sistema.dash-professor.detalhes', [$usuario->id, 3]) }}" href="javascript:;">
                                        <div class="row justify-content-between align-items-center text-center text-md-left">
                                            <div class="col-12 col-md-auto">
                                                <div class="d-flex align-content-center">
                                                    <div>Bloqueado</div>
                                                    <button type="button" data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="right"
                                                            data-title = "Valores Bloqueados"
                                                            data-content="Valores de aulas contestadas por alunos">
                                                        <i class="fas fa-question-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-auto text-bold">{{ currencyToApp($bloqueado) }}</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>

                            <div class="row">
                                @if( $usuario->present()->checkDadosbancarios() )
                                    <div class="col-sm-7">
                                        <small class="form-text text-danger text-center text-md-left">
                                            Para autorizar a transferência do seu saldo clique no botão ao lado
                                        </small>
                                    </div>
                                    <div class="col-sm-5 mt-3 mt-md-0 text-center text-md-right">
                                        <button type="button" class="btn btn-danger text-bold" data-toggle="modal" data-target="#staticBackdrop">
                                            Solicitar Transferência <i class="fas fa-comment-dollar ml-1"></i>
                                        </button>

                                        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4 text-left">
                                                        <dl>
                                                            <dt>Solicitar transferência</dt>
                                                            <dd>
                                                                Deseja realmente realizar a transferência do seu saldo
                                                                disponível
                                                                para sua conta bancária
                                                            </dd>
                                                        </dl>
                                                        <div class="text-right">
                                                            <button type="button" class="btn btn-sm btn-danger submit-simple-url-load" data-url="{{ route('sistema.dash-professor.transferencia') }}">
                                                                Confirmar
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-light"
                                                            data-dismiss="modal">
                                                                Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-danger text-bold">
                                        Complete  seus dados financeiros para solicitar a transferência <i class="fas fa-arrow-right"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 dados-bancarios">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0 text-danger text-bold">Dados Bancários</h5>
                        </div>
                        <div class="card-body">
                            @if($usuario->alterou_conta == 1)
                                <div class="bold alert alert-warning">
                                    Verifique sua caixa de e-mails. Existe uma alteração de dados pendente de confirmação.
                                </div>
                            @endif
                            @error('atualizaok')
                                <div class="row text-purple text-12-pt bold">
                                    Dados atualizados com sucesso!
                                </div>
                            @enderror
                            <form data-action="{{ route('sistema.dash-professor.financeiro.salvar') }}" class="form-normal">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_conta_tmp" id="inputAccountCurrent" value="1"  @if( $usuario->tipo_conta == 1) checked @endif>
                                            <label class="form-check-label" for="inputAccountCurrent">Conta Corrente</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_conta_tmp" id="inputSavingsAccount" value="2" @if( $usuario->tipo_conta == 2) checked @endif>
                                            <label class="form-check-label" for="inputSavingsAccount">Conta Poupança</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <select name="banco_tmp" id="banco" class="form-control select2 banco" style="width: 100%;">
                                            <option value="">--SELECIONE--</option>
                                            @foreach($bancos as $b)
                                                <option value="{{ $b->id }}">{{ $b->id . ' - ' . $b->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <input type="text" name="agencia_tmp" id="inputAgency" class="form-control" maxlength="8" placeholder="Agência (Sem o dígito)" value="{{ $usuario->agencia }}">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <input type="text" name="agencia_digito_tmp" id="" class="form-control" maxlength="1" placeholder="Dígito" value="{{ $usuario->agencia_digito }}">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <input type="text" name="conta_tmp" id="inputAccount" class="form-control" maxlength="12" placeholder="Conta" value="{{ $usuario->conta }}">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <input type="text" name="digito_tmp" id="inputDigit" class="form-control" maxlength="1" placeholder="Dígito" value="{{ $usuario->digito }}">
                                    </div>
                                </div>

                                <small class="form-text text-danger">
                                    *Essa conta será criada no MOIP para repasse dos valores dos produtos vendidos em
                                    nossa plataforma
                                </small>

                                <div class="mt-4 text-center text-md-right">
                                    <button type="submit" class="btn btn-danger text-bold">
                                        Salvar <i class="fas fa-save ml-1"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MAIN CONTENT -->
</div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.banco').val('{{ $usuario->banco }}').change();
            if ($(document).width() <= 768) {
                var goto = $('.dados-bancarios').offset().top;
                $("html, body").animate({ scrollTop: goto }, 1000, "");
            }
        });
    </script>
@stop