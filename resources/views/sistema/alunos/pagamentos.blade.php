@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-exclamation"></i> Meu Plano - Status </h1>
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

                    <div class="card card-primary card-border-azul">
                        <div class="card-header-custom-gray padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                            <div class="row">
                                <div class="col-lg-3">
                                    <h2>Meu Plano EAD </h2>
                                </div>
                                <div class="col-lg-5">
                                </div>
                                <div class="col-lg-2">
                                    <h3><b>Status do Plano</b></h3>
                                </div>
                                <div class="col-lg-2"></div>
                            </div>

                        </div>
                        <div class="card-body p-0 padding-bottom-30">

                            <div class="row table-responsive">
                                <div class="col-lg-12 padding-left-15 padding-right-15">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="body-pagamento">
                                                <td class="padding-top-5 padding-bottom-5 text-center">{{ $usuario->plano->nome }} <span class="valor">{{ currencyToApp($usuario->plano->valor) }}</span></td>
                                                @if( $usuario->validade_assinatura != null )
                                                    <td class="padding-top-5 padding-bottom-5 text-center">Válido até: {{ dateBdToApp($usuario->validade_assinatura) }}</td>
                                                @endif
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    @if( $usuario->status_pedido == 0 )
                                                        <div class="warning bg-warning margin-right-5 margin-left-5">Aguardando Pagamento</div>
                                                    @endif
                                                    @if( $usuario->status_pedido == 1 )
                                                        <div class="warning warning-green margin-right-5 margin-left-5">Pago</div>
                                                    @endif
                                                    @if( $usuario->status_pedido == 2 )
                                                        <div class="warning bg-danger margin-right-5 margin-left-5">Atrasado</div>
                                                    @endif
                                                </td>
                                                @if( $usuario->status_pedido == 1 )
                                                    <td class="text-center">
                                                        <a data-url="{{ route('sistema.alunos.vod.assinatura.cancelar') }}" data-texto="Uma vez cancelada sua assinatura, você perderá o acesso aos cursos pagos! Confirma?" class="btn-red-circle submit-single-post">Cancelar Assinatura</a>
                                                    </td>
                                                @endif
                                                @if( $usuario->status_pedido == 2 )
                                                    <td class="text-center">
                                                        <a href="{{ route('sistema.sua-conta.pagamento') }}" class="btn-roxo margin-top-10 pointer btn-alterar-plano">Realizar Pagamento</a>
                                                    </td>
                                                @endif
                                                @if( $usuario->validade_assinatura == null )
                                                    <td class="text-center">
                                                        <a href="{{ route('sistema.sua-conta.pagamento') }}" class="btn-roxo margin-top-10 pointer btn-alterar-plano">Realizar Novo Pagamento</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card card-primary card-border-azul">
                        <div class="card-header-custom-gray padding-top-10 padding-left-15 padding-right-15">
                            <div class="row">
                                <div class="col-lg-3">
                                    <h2>Histórico de Pagamentos EAD </h2>
                                </div>
                            </div>
                            <div class="row table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="cabecalho-grid-pagamento margin-top-10">
                                            <th class="bold padding-top-5 padding-bottom-5 padding-left-10">Data da Transação</th>
                                            <th class="bold padding-top-5 padding-bottom-5 padding-left-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usuario->historico as $historico)
                                            <tr class="body-pagamento">
                                                <td class="padding-top-5 padding-bottom-5 padding-left-10">
                                                    {{ $historico->created_at->format('d/m/Y H:i:s') }}
                                                </td>
                                                <td class="padding-top-5 padding-bottom-5 padding-left-10 text-center">
                                                    @if( $historico->status == 1)
                                                        <div class="warning warning-green margin-right-5 margin-left-5">Pago</div>
                                                    @endif
                                                    @if( $historico->status == 2)
                                                        <div class="warning warning-pink margin-right-5 margin-left-5">Não Pago</div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-body p-0 padding-bottom-30 padding-left-15 padding-right-15">
                            <div class="col-12">
                                
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
