@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="view_cart">
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
                    <a class="nav-link @if( $planoE == null )active @endif" id="package-tab" data-toggle="tab" href="#package" role="tab"
                       aria-controls="package" aria-selected="true">
                        1. Escolha o plano
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link @if( $planoE != null )active @endif disabled cadastro" id="register-tab" data-toggle="tab" href="#register" role="tab"
                       aria-controls="register" aria-selected="false">
                        2. Faça o seu cadastro
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link pagamento disabled" id="payment-tab" data-toggle="tab" href="#payment" role="tab"
                       aria-controls="payment" aria-selected="false">
                        3. Realize o pagamento
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="cartStepsContent">
                <div class="tab-pane fade @if( $planoE == null )show active @endif" id="package" role="tabpanel" aria-labelledby="package-tab">
                    <div class="view_cart_content_packages">
                        <div class="row">
                            @foreach( $planos->where('exibir', 1) as $plano )
                                <div class="col-12 col-md-6 col-xl-3 my-4">
                                    <article>
                                        <header>
                                            <span class="headline">{{ $plano->nome }}</span>
                                            {{-- <h3>Mensal</h3> --}}
                                            <p>{{ $plano->descricao }}</p>
                                        </header>

                                        <div class="details">
                                            <p>{{ currencyToApp($plano->valor) }}</p>

                                            <input type="radio" name="package" class="radio-plano" id="plano_{{ $plano->id }}" value="{{ $plano->slug }}" data-paypal="{{ $plano->plano_id_paypal == null ? 'null' : $plano->plano_id_paypal }}" data-id="{{ $plano->id }}" data-gratuito="{{ $plano->gratuito }}" data-step="#register" data-descricao="{{ $plano->descricao }}" data-titulo="{{ $plano->nome }}" data-valor="{{ currencyToApp($plano->valor) }}">
                                            <label for="plano_{{ $plano->id }}">Quero este</label>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if( $planoE != null )show active @endif" id="register" role="tabpanel" aria-labelledby="register-tab">
                    <div class="view_cart_content_register container-fluid limit">
                        <p class="title">Você escolheu o plano</p>
                        <div class="resume">
                            <div class="resume_product">
                                <div class="resume_product_header">
                                    <div class="thumb" style="background-image: url('{{assets('sistema/images/backgrounds/background-show.png') }}"></div>
                                    <div class="text">
                                        <p>{{ optional($planoE)->nome }}</p>
                                        <span>{{ optional($planoE)->descricao }}</span>
                                    </div>
                                </div>

                                <div class="resume_product_price">
                                    {{ currencyToApp(optional($planoE)->valor) }}
                                </div>
                            </div>

                            <div class="resume_total">
                                <span>Total</span>
                                <p>{{ currencyToApp(optional($planoE)->valor) }}</p>
                            </div>
                        </div>
                        <div class="row padding-15">
                            <div class="col-lg-8 padding-right-50 xs-padding-0 {{ $planoE ?? 'center-block' }}">
                                <div class="row">
                                    <form class="view_cart_content form-normal" data-action="{{ route('sistema.vod.assinatura.cadastro') }}">
                                        <input type="hidden" name="plano_id" class="plano_id" value="{{ optional($planoE)->id }}">
                                        <input type="hidden" name="plano_paypal" class="plano_paypal" value="">
                                        <p class="title">Para continuar, cadastre-se...</p>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputFirstName">Nome</label>
                                                <input type="text" name="nome" class="form-control" id="" placeholder="Digite aqui...">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputLastName">Sobrenome</label>
                                                <input type="text" name="sobrenome" class="form-control" id="" placeholder="Digite aqui...">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail">E-mail</label>
                                                <input type="email" name="email" class="form-control" id="" placeholder="Digite aqui..." autocomplete="new-password">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputEmailRepeat">Repetir e-mail</label>
                                                <input type="email" name="email_confirmation" class="form-control" id="" placeholder="Digite aqui..." autocomplete="new-password">
                                            </div>
                                        </div>

                                         <div class="form-row padding-bottom-20">
                                            <label for="inputEmail">País</label>
                                            <select name="pais" class="form-control pais">
                                                <option value="0">--SELECIONE--</option>
                                                <option value="1">Brasil</option>
                                                <option value="2">Outros</option>
                                            </select>
                                        </div> 
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputWhatsApp">WhatsApp</label>
                                                <input type="text" name="whatsapp" class="form-control telefone-input-mask" id="" placeholder="Digite aqui...">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword">Senha</label>
                                                <input type="password" name="senha" class="form-control" id="" placeholder="Digite aqui..." autocomplete="new-password">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputPasswordRepeat">Confirmar senha</label>
                                                <input type="password" name="senha_confirmation" class="form-control" id="" placeholder="Digite aqui..." autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <div class="icheck-primary d-inline text-gray text-22-pt">
                                                    <input type="checkbox" id="termos" name="termos" value="1" required>
                                                    <label for="termos" class="medium">
                                                        Declaro que li e aceito os <a data-fancybox="" data-type="iframe" data-src="{{ route('sistema.termos') }}" href="javascript:;">Termos de Uso</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if( $planoE == null )
                                            <button type="submit" class="btn-cadastro">Pronto, realizar pagamento</button>
                                        @else
                                            <button type="submit" class="btn-cadastro">Realizar cadastro</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            @if(isset($planoE) )
                                <div class="col-lg-4 padding-left-20 xs-padding-0 bg-white">
                                    <p class="title">Ou, faça seu login!</p>
                                    <form data-action="{{ route('sistema.login') }}" autocomplete="off" class="form-normal w-100">
                                        <input type="hidden" name="plano" value="{{ optional($planoE)->id }}">
                                        <div class="form-group">
                                            <label for="inputPasswordRepeat">E-mail</label>
                                            <input type="email" name="email" class="form-control" id="inputUser" placeholder="E-mail">
                                        </div>
                
                                        <div class="form-group">
                                            <label for="inputPasswordRepeat">Senha</label>
                                            <input type="password" name="senha" class="form-control" id="inputPass" placeholder="Senha">
                                        </div>
                
                                        <div class="form-group">
                                            <a data-fancybox data-type="iframe" data-src="{{ route('sistema.recuperar-senha') }}" href="javascript:;">Esqueceu a senha?</a>
                                        </div>
                
                                        <button type="submit">Fazer Login</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<a data-fancybox data-type="iframe" class="d-none modal-exterior" data-src="{{ route('sistema.vod.assinatura.exterior') }}" href="javascript:;"></a>
@stop
@section('scripts')
    <link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
    <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>        
    <script src="{{assets('sistema/js')}}/cadastro.js"></script>   
@stop