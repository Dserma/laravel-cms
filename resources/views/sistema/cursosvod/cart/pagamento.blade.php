@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="view_cart pagamento">
    <header class="view_cart_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="?file=courses">Cursos</a></li>
                    <li class="breadcrumb-item"><a href="?file=">Guitarpedia Premium</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assinatura</li>
                </ol>
            </nav>

            <h1>Escolha <b>seu plano</b></h1>
            <p>Tenha acesso a + de 1400 aulas partir de <b>R$39,90 por mês</b></p>
        </div>
    </header>

        <div class="container">
            <ul class="nav nav-tabs view_cart_content_menu" id="cartSteps" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link disabled" id="package-tab" data-toggle="tab" href="#package" role="tab"
                       aria-controls="package" aria-selected="true">
                        1. Escolha o plano
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link disabled" id="register-tab" data-toggle="tab" href="#register" role="tab"
                       aria-controls="register" aria-selected="false">
                        2. Faça o seu cadastro
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link pagamento active" id="payment-tab" data-toggle="tab" href="#payment" role="tab"
                       aria-controls="payment" aria-selected="false">
                        3. Realize o pagamento
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="cartStepsContent">
                <div class="tab-pane fade active show" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                    <div class="view_cart_content_pay">
                        <p class="title">Você está contratando o plano</p>
                        <div class="resume">
                            <div class="resume_product">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="thumb" style="background-image: url('{{assets('sistema/images/backgrounds/background-show.png') }}')"></div>
                                    </div>
                                    <div class="col-lg-9 text padding-left-10">
                                        <div class="row">
                                            <p>{{ $plano->nome }}</p>
                                        </div>
                                        <div class="row">
                                            <span class="date">Início: {{ date('d/m/Y') }} - Fim: {{ endPlan($plano->dias) }}</span>
                                        </div>
                                        @if($plano->valor == Session('valorPlano') )
                                            <div class="row">
                                                <span class="price">Valor: {{ currencyToApp($plano->valor) }}</span>
                                            </div>
                                            @else
                                            <div class="row margin-top-5">
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <span class="text-14-pt bold">Cupom já aplicado! {{ Session('cupom') }}% de desconto.</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 padding-right-30">
                                                    <div class="row horizontal-right">
                                                        <button class="remove-cupom submit-single-post" data-url="{{ route('sistema.vod.remove-cupom') }}" data-texto="Confirma a remoção deste cupom?">Remover</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row vertical-middle">
                                                <span class="price-old">De: {{ currencyToApp($plano->valor) }}</span>
                                                <span class="price padding-left-20">Por: {{ currencyToApp(Session('valorPlano')) }}</span>
                                            </div>
                                                
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{--  <button class="resume_product_edit" type="button" data-step="#package">
                                    trocar plano
                                </button>  --}}
                            </div>
                        <div class="row horizontal-center margin-top-50">
                            <p class="title text-20-pt semibold">Formas de pagamento</p>
                        </div>

                        <ul class="nav nav-tabs justify-content-center" id="paymentTab" role="tablist">
                            @if( $usuario->pais == 2 )
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="" data-toggle="tab" href="#internacional" role="tab"
                                    aria-controls="paypal" aria-selected="false">Paypal</a>
                                </li> 
                            @else
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="credit-tab" data-toggle="tab" href="#credit" role="tab"
                                    aria-controls="credit" aria-selected="true">Cartão de Crédito</a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="bullet-tab" data-toggle="tab" href="#bullet" role="tab"
                                    aria-controls="bullet" aria-selected="false">Boleto Bancário</a>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content" id="paymentTabContent">
                            @if( $usuario->pais == 2 )
                                <div class="tab-pane fade @if( $usuario->pais == 2 ) show active @endif" id="internacional" role="tabpanel" aria-labelledby="">
                                    <div class="row margin-top-30 horizontal-center">
                                        <div id="paypal-button-container" class="padding-bottom-50"></div>
                                    </div>
                                </div>
                            @else
                                <div class="tab-pane fade show active padding-bottom-50" id="credit" role="tabpanel" aria-labelledby="credit-tab">
                                    <div class="text-center mb-5">
                                        <img src="{{ assets('sistema/images/icons/flags-card.png') }}" alt="Bandeiras de Cartão de Crédito">
                                    </div>
                                    @if($plano->valor == Session('valorPlano') )
                                        <form data-action="{{ route('sistema.sua-conta.pagamento.cupom') }}" class="form-normal form-cupom">
                                            <input type="hidden" name="plano_id" value="{{ $plano->id }}">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <label for="inputCupom">Cupom de desconto</label>
                                                    <input type="search" name="cupom" class="form-control" id="inputCupom" placeholder="Digite aqui...">
                                                </div>
                                                <div class="col-md-3 margin-top-10 vertical-top">
                                                    <button type="submit" class="validate_cupom">VALIDAR CUPOM</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                    <form data-action="{{ route('sistema.vod.pagamento.cartao') }}" class="form-normal margin-top-30">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputName">Nome</label>
                                                <input type="text" disabled name="name" value="{{ $aluno->nome }}" class="form-control disabled" id="inputName" placeholder="Digite aqui...">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputMail">E-mail</label>
                                                <input type="email" disabled name="email" value="{{ $aluno->email }}" class="form-control disabled" id="inputMail" placeholder="Digite aqui...">
                                            </div>
                                        </div>
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
                                        <button type="submit">Pagar agora!</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade padding-bottom-50" id="bullet" role="tabpanel" aria-labelledby="bullet-tab">
                                    <div class="row margin-top-20 horizontal-center">
                                        <img src="{{ assets('sistema/images/boleto.png') }}" alt="">
                                    </div>
                                    <form data-action="{{ route('sistema.vod.pagamento.boleto') }}" class="form-normal cadastro">
                                        <div class="row margin-top-20 margin-bottom-20">
                                            <div class="col-lg-6">
                                                <label for="">CPF para o boleto</label>
                                                <input type="text" name="cpf" class="form-control cpf cpf-input-mask">
                                            </div>
                                        </div>
                                        <button type="submit" class="button-green-solid">Gerar Boleto <i class="fas fa-plus-circle margin-left-10"></i></button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@stop
@section('scripts')
    <link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
    <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>        
    @if( $usuario->pais == 2 )
        <script src="https://www.paypal.com/sdk/js?client-id={{ config('app.paypal.prod.key') }}&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
        <script>
            $(document).ready(function(){
                paypal.Buttons({
                    style: {
                        shape: 'pill',
                        color: 'blue',
                        layout: 'horizontal',
                        label: 'subscribe'
                    },
                    createSubscription: function(data, actions) {
                      return actions.subscription.create({
                        'plan_id': '{{ $usuario->plano->plano_id_paypal }}'
                      });
                    },
                    onApprove: function(data, actions) {
                        atualizaAssinaturaPaypal(data.subscriptionID);
                    }
                }).render('#paypal-button-container');
            })
        </script>
    @endif
@stop