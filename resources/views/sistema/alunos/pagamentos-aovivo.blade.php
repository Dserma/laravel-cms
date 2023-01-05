@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-dollar-sign"></i> Meus Pedidos - Ao Vivo </h1>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($usuario->pedidos->sortByDesc('created_at') as $pedido)
                                            <tr class="body-pagamento">
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    {{ $pedido->created_at->format('d/m/Y H:i:s') }}
                                                </td>
                                                <td class="padding-top-5 padding-bottom-5 text-center">
                                                    @foreach( $pedido->items as $item )
                                                        {{ $item->aula->present()->nomeAula() }} (x{{ $item->quantidade }}) <br>
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
                                            </tr>
                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
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
@stop
