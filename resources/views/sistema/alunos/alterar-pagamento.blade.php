@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-dollar-sign"></i> Meu Plano - Alterar Pagamento </h1>
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
                                        @if( $usuario->plano->gratuito == 0 )
                                            <div class="row margin-top-50 padding-bottom-20 alterar-forma">
                                                <h4>Alterar forma de Pagamento ou Alterar cartão de crédito</h4>
                                            </div>
                                            <div class="row divisor"></div>
                                            <div class="row margin-top-10 text-16-pt regular line-24 flex-column">
                                                <p>Abaixo, você poderá alterar a sua forma de pagamento atual, bem como trocar o cartão de crédito utilizado também.</p>
                                                <p>Gostaríamos apenas de salientar que esta alteração só passará a valer para a proxima cobrança.</p>
                                            </div>
                                            <div class="row view_cart_content_pay margin-top-30">
                                                <ul class="nav nav-tabs justify-content-center text-20-pt" id="paymentTab" role="tablist">
                                                    {{--  <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab"
                                                        aria-controls="paypal" aria-selected="false">Paypal</a>
                                                    </li>  --}}
                        
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active" id="credit-tab" data-toggle="tab" href="#credit" role="tab"
                                                        aria-controls="credit" aria-selected="true">Cartão de Crédito</a>
                                                    </li>
                        
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="bullet-tab" data-toggle="tab" href="#bullet" role="tab"
                                                        aria-controls="bullet" aria-selected="false">Boleto Bancário</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="row view_cart_content_pay">
                                                <div class="tab-content" id="paymentTabContent">
                                                    <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                                                        ...
                                                    </div>
                        
                                                    <div class="tab-pane fade show active padding-bottom-20" id="credit" role="tabpanel" aria-labelledby="credit-tab">
                                                        <div class="text-center">
                                                            <img src="{{ assets('sistema/images/icons/flags-card.png') }}" alt="Bandeiras de Cartão de Crédito">
                                                        </div>
                                                        <form data-action="{{ route('sistema.alunos.vod.assinatura.alterar.cartao') }}" class="form-normal margin-top-10">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputCardNumber">Número do cartão</label>
                                                                    <input type="text" name="cartao" class="form-control credit-input-mask" id="inputCardNumber" placeholder="Digite aqui...">
                                                                </div>
                        
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputCardHold">Nome impresso no cartão</label>
                                                                    <input type="text" name="titular" class="form-control" id="inputCardHold" placeholder="Digite aqui...">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-3">
                                                                    <label for="inputCardValidate">Validade</label>
                                                                    <input type="text" name="validade" class="form-control validade-input-mask-2" id="inputCardValidate" placeholder="mm/aa">
                                                                </div>
                        
                                                                <div class="form-group col-md-3">
                                                                    <label for="inputCardCVV">CVV</label>
                                                                    <input type="text" name="cvv" class="form-control cvv-input-mask" id="inputCardCVV" maxlength="4">
                                                                </div>
                        
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputCPF">CPF</label>
                                                                    <input type="text" name="cpf" class="form-control cpf-input-mask" id="inputCPF">
                                                                </div>
                                                            </div>
                                                            <button type="submit">Usar Cartão de Crédito</button>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade padding-bottom-50" id="bullet" role="tabpanel" aria-labelledby="bullet-tab">
                                                        <div class="row margin-top-20 horizontal-center">
                                                            <img src="{{ assets('sistema/images/boleto.png') }}" alt="">
                                                        </div>
                                                        <form data-action="{{ route('sistema.alunos.vod.assinatura.alterar.boleto') }}" class="form-normal cadastro">
                                                            <div class="row margin-top-20 margin-bottom-20">
                                                                <div class="col-lg-6 center-block">
                                                                    <label for="">CPF para o boleto</label>
                                                                    <input type="text" name="cpf" class="form-control cpf cpf-input-mask">
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="button-green-solid">Usar Boleto <i class="fas fa-plus-circle margin-left-10"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
