@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->
    <section class="view_teachers_register">
        <header class="view_teachers_register_header text-center text-xl-left">
            <div class="container">
                <nav class="mb-4" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center justify-content-xl-start">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Seja professor</li>
                    </ol>
                </nav>

                <h1>Seja professor</h1>
                <p>Preencha o formulário abaixo</p>
            </div>
        </header>

        <div class="view_teachers_register_form">
            <div class="container">
                <h4 class="view_teachers_register_form_title">Preencha o formulário</h4>
                <form data-action="{{ route('sistema.professor.cadastrar') }}" class="form-normal">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputFirstName">Nome</label>
                            <input type="text" name="nome" class="form-control" id="inputFirstName" placeholder="Digite aqui...">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputLastName">Sobrenome</label>
                            <input type="text" name="sobrenome" class="form-control" id="inputLastName" placeholder="Digite aqui...">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail">E-mail</label>
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Digite aqui...">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmailRepeat">Repetir e-mail</label>
                            <input type="email" name="email_confirmation" class="form-control" id="inputEmailRepeat" placeholder="Digite aqui...">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPassword">Senha</label>
                            <input type="password" name="senha" class="form-control" id="inputPassword" placeholder="Digite aqui...">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPasswordRepeat">Confirmar senha</label>
                            <input type="password" name="senha_confirmation" class="form-control" id="inputPasswordRepeat" placeholder="Digite aqui...">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Telefone</label>
                            <input type="text" name="telefone" class="form-control telefone-input-mask" id="inputPhone" placeholder="Digite aqui...">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputWhatsApp">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control telefone-input-mask" id="inputWhatsApp" placeholder="Digite aqui...">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="icheck-primary d-inline text-gray text-22-pt">
                                <input type="checkbox" id="termos" name="termos" value="1" required>
                                <label for="termos" class="medium">
                                    Declaro que li e aceito os <a data-fancybox="" data-type="iframe" data-src="{{ route('sistema.aovivo.termo-professor') }}" href="javascript:;">Termos de Uso</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit">Realizar meu cadastro</button>
                </form>
            </div>
        </div>

    </section>
@stop

@section('scripts')
    <link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
    <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>        
    <script>
        $(document).ready(function(){
            if ($(document).width() < 768) {
                $target = $('.view_teachers_register_form').offset().top;
                $('html, body').animate({ scrollTop: $target }, 800);
            }
        })
    </script>
@stop