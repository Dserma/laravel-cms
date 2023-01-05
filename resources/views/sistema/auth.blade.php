@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="auth-login padding-bottom-50">
    <header class="view_cart_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="?file=courses">Login</a></li>
                </ol>
            </nav>
            <h1>Faça seu login abaixo</b></h1>
        </div>
    </header>
    <div class="container">
        <div class="margin-top-50">
                <div class="col-lg-8 padding-right-50 xs-padding-10 view_cart_content_register">
                    <div class="row">
                        <form class="view_cart_content form-normal" data-action="{{ route('sistema.vod.assinatura.cadastro') }}">
                            <input type="hidden" name="from" value="cart">
                            <input type="hidden" name="plano_id" class="plano_id" value="{{ $plano }}">
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
                            <button type="submit" class="btn-cadastro">Pronto, realizar pagamento</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 padding-left-20 xs-padding-10 bg-white view_cart_content_register">
                    <p class="title">Ou, faça seu login!</p>
                    <form data-action="{{ route('sistema.login') }}" autocomplete="off" class="form-normal w-100">
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
        </div>
    </div>
</section>
@stop
@section('scripts')
    <link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
    <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>        
@stop