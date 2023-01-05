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
                    <li class="breadcrumb-item"><a href="#">Alterar Senha</a></li>
                </ol>
            </nav>
            <h1>Altere sua senha abaixo:</b></h1>
        </div>
    </header>
    <div class="container">
        <div class="row margin-top-50">
            <div class="col-lg-4 center-block login padding-40">
                <div class="row vertical-middle text-20-pt">
                    <i class="fas fa-lock padding-right-10"></i> Alterar senha
                </div>
                <div class="row vertical-middle text-20-pt">
                    {{ isset($aluno) ? $aluno->fullName : $professor->fullName }}
                </div>
                <div class="row margin-top-20">
                    @if( isset($aluno) )
                        <form data-action="{{ route('sistema.nova-senha.post') }}" autocomplete="off" class="form-normal w-100">
                        <input type="hidden" name="id" value="{{ $aluno->id }}">
                    @endif
                    @if( isset($professor) )
                        <form data-action="{{ route('sistema.nova-senha.professor.post') }}" autocomplete="off" class="form-normal w-100">
                        <input type="hidden" name="id" value="{{ $professor->id }}">
                    @endif
                        
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <input type="password" name="senha" class="form-control" id="inputUser" placeholder="Senha">
                        </div>

                        <div class="form-group">
                            <input type="password" name="senha_confirmation" class="form-control" id="inputPass" placeholder="Confirmar Senha">
                        </div>

                        <button type="submit">Alterar senha</button>
                    </form>
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
@stop