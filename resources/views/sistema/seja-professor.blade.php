@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header-teachers")
<!--MAIN HEADER-->

<section class="view_teachers_go">
    <header class="view_teachers_go_header text-center">
        <div class="container">
            <h1>Seja um professor <b>Guitarpedia</b></h1>
            <p>Cadastre-se e <b>ofereça suas aulas online</b></p>
            <a title="Cadastre-se" href="{{ route('sistema.professor.cadastro') }}">CADASTRAR</a>
        </div>

        <div class="view_teachers_go_header_anchor" data-go=".view_teachers_go_guide">
            <i class="fas fa-arrow-down"></i>
        </div>
    </header>

    <section class="view_teachers_go_guide">
        <div class="container">
            <header class="view_teachers_go_guide_header mb-5 text-center">
                <img src="{{ assets('sistema/images/icons/guitar.png') }}" title="Vantagens de ser um professor!"
                     alt="Vantagens de ser um professor!">
                     {!! $como->titulo !!}
            </header>

            <div class="row">
                @foreach( json_decode($como->passos)->passos as $passo )
                    <div class="col-12 col-xl-6 my-4 my-xl-5">
                        <article class="text-center text-xl-left">
                            <div class="number mb-3 mb-xl-0">0{{ $loop->index + 1 }}</div>
                            <header>
                                <h3>{{ $passo->titulo }}</h3>
                                {!! $passo->conteudo !!}
                            </header>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!--VIEW HOME TEACHERS-->
    @include("sistema/includes/section-teachers-live")
    <!--VIEW HOME TEACHERS-->

    <!--SECTION TESTESMONIALS-->
    @include("sistema/includes/section-testemonials")
    <!--SECTION TESTESMONIALS-->

    <!--SECTION ABOUT-->
    @include("sistema/includes/section-about")
    <!--SECTION ABOUT-->

    <section class="view_teachers_go_cta">
        <div class="container">
            <header class="view_teachers_go_cta_header">
                <span>NÃO PERCA TEMPO</span>
                <h2>Se torne um professor <b>cadastre-se agora!</b></h2>
            </header>

            <a title="Cadastra-se" href="{{ route('sistema.professor.cadastro') }}">Quero me cadastrar agora!</a>
        </div>
    </section>
</section>