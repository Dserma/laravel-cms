@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-random"></i> Meu Plano - Alterar </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row padding-left-20 xs-padding-5">
                <div class="col-md-12">
                    {{-- <div class="card card-primary card-border-azul">
                        <div class="card-header-custom-gray padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                            <h2>Aulas ao Vivo </h2>
                        </div>
                        <div class="card-body p-0 padding-bottom-30">
                            <div class="table-responsive">
                                <div class="col-lg-12 padding-left-15 padding-right-15">
                                    <table class="table table-bordered w-100">
                                        <thead>
                                            <tr class="cabecalho-grid-pagamento">
                                                <th class="text-center">Data da Compra</th>
                                                <th class="text-center">Aulas ao Vivo</th>
                                                <th class="text-center">Valor</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($usuario->pedidos as $pedido)
                                            <tr class="body-pagamento">
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    {{ $pedido->created_at->format('d/m/Y H:i:s') }}
                                                </td>
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    @foreach( $pedido->items as $item )
                                                        {{ $item->aula->present()->nomeAula() }} <br>
                                                    @endforeach
                                                </td>
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    {{ currencyToApp($pedido->valor) }}
                                                </td>
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    @if( $pedido->status == 0)
                                                        <div class="warning warning-blue margin-right-5 margin-left-5">Aguardando</div>
                                                    @endif
                                                    @if( $pedido->status == 1)
                                                        <div class="warning warning-green margin-right-5 margin-left-5">Pago</div>
                                                    @endif
                                                    @if( $pedido->status == 2)
                                                        <div class="warning warning-pink margin-right-5 margin-left-5">Não Pago</div>
                                                    @endif
                                                </td>
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    <a class="btn btn-danger text-white">Cancelar Pedido</a>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div> --}}
                    <!-- /.card -->


                    <div class="card card-primary card-border-azul">
                        <div class="card-body p-0 padding-bottom-30">

                            <div class="row table-responsive">
                                <div class="col-lg-12 padding-left-15 padding-right-15">
                                    <div class="novos-planos" id="collapseExample">
                                        @if( $errors->any() || $request->alterar == 'alterar' )
                                            <div class="col-12 margin-top-10 text-18-pt text-red bold">
                                                Voce tem acesso apenas aos cursos gratuitos. Altere seu plano para ter acesso a todos os cursos do Guitarpedia.
                                            </div>
                                        @endif
                                        <div class="row margin-top-20 quick text-gray text-22-pt semibold">
                                            Novos Planos
                                        </div>
                                        <div class="row margin-top-10">
                                            @foreach( $planos->where('gratuito', '!=', 1)->where('exibir', 1) as $plano )
                                                @if( $usuario->plano->id != $plano->id)
                                                    <div class="col-lg-3">
                                                        <div class="row">
                                                            <div class="col-md-11 plano center-block">
                                                                <div class="row cabecalho flex-column padding-bottom-70">
                                                                    <div class="row padding-top-35 quick text-white text-30-pt bold text-center horizontal-center">
                                                                        {{ $plano->nome }}
                                                                    </div>
                                                                </div>
                                                                <div class="row body flex-column relative">
                                                                    <div class="col-md-11 center-block conteudo padding-35">
                                                                        <div class="row margin-top-15 horizontal-center quick text-gray text-15-pt medium">
                                                                            {{ $plano->descricao }}
                                                                        </div>
                                                                        <div class="row margin-top-10 quick text-red-2 text-35-pt bold horizontal-center">
                                                                            {{ currencyToApp($plano->valor) }}
                                                                        </div>
                                                                        <div class="row margin-top-30 horizontal-center">
                                                                            @if( $usuario->plano->exibir == 0 || $usuario->plano->gratuito == 1 )
                                                                                <button data-url="{{ route('sistema.alunos.vod.assinatura.trocar', [$plano->slug,1]) }}"  data-exibir="true" data-cupom="true" data-texto="Você está alterando seu plano para o <b>{{ $plano->nome }}</b>.<br><br>Você ainda <b>não possui uma assinatura paga em nosso site</b>, por isso precisamos que você <b>coloque seus dados de faturamento para enviarmos à instituição financeira</b>, para que um pagamento recorrente seja criado.<br><br>Tudo bem?" class="btn btn-red-circle btn-square toupper bold text-1-pt submit-single-post btn-plano_{{ $plano->id }}">Quero Este</button>
                                                                            @else
                                                                                <button data-url="{{ route('sistema.alunos.vod.assinatura.trocar', $plano->slug) }}"  data-exibir="false" data-cupom="true" data-url-cupom="{{ route('sistema.alunos.vod.check-cupom') }}" data-plano="{{ $plano->id }}" data-texto="Você está alterando seu plano para o <b>{{ $plano->nome }}</b>.<br><br>Isso irá alterar o <b> valor e a data de cobrança</b> do seu plano atual!<br><br><b>Confirma a troca do seu plano atual, por este?</b>" class="btn btn-red-circle btn-square toupper bold text-1-pt submit-single-post btn-plano_{{ $plano->id }}">Quero Este</button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@stop
@section('scripts')
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>      
    @if( $errors->any() || $request->alterar != null )
        <script>
            $(document).ready(function(){
                $('.btn-alterar-plano').click();
                @if(strlen($request->alterar) == 1)
                    confirmaPost($('.btn-plano_{{ $request->alterar }}'), true);
                @endif
                @if( $request->alterar == 'expirada' )
                    $('html, body').animate({ scrollTop: $('.alterar-forma').offset().top }, 800);
                @endif
            })
        </script>
    @endif  
@stop
