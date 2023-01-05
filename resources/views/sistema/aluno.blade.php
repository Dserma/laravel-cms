@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header-students")
<!--MAIN HEADER-->

<section class="view_students_go">
    <header class="view_students_go_header text-center text-xl-left">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-6 mb-5 mb-xl-0">
                    <img src="{{ assets('sistema/images/icons/guitar-light.png') }}" title="Seja um aluno Guitarpedia" alt="Seja um aluno Guitarpedia">
                   {!! $como->banner !!}
                    <a title="Ver Planos" href="{{ route('sistema.planos') }}">Ver Planos</a>
                </div>

                <div class="col-12 col-xl-6">
                    <img src="{{ assets('sistema/images/icons/classes-online.png') }}" title="Seja um aluno Guitarpedia"
                         alt="Seja um aluno Guitarpedia">
                    <span>Aulas ao vivo individuais</span>
                    <p>Escolha a aula, o professor e comece <b>agora mesmo!</b></p>
                    <a title="Ver Planos" href="{{ route('sistema.aluno.aovivo') }}">Agendar aula</a>
                </div>
            </div>
        </div>

        <div class="view_students_go_header_anchor" data-go=".view_students_go_guide">
            <i class="fas fa-arrow-down"></i>
        </div>
    </header>

    <section class="view_students_go_guide">
        <div class="container">
            <header class="view_students_go_guide_header mb-5 text-center">
                <img src="{{ assets('sistema/images/icons/guitar.png') }}" title="Vantagens de ser um aluno!"
                     alt="Vantagens de ser um aluno!">
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

    <!--VIEW HOME ONLINE-->
    {{-- @include("sistema/includes/section-online") --}}
    <!--VIEW HOME ONLINE-->

    <!--VIEW HOME TESTEMONIALS-->
    @include("sistema/includes/section-testemonials")
    <!--VIEW HOME TESTEMONIALS-->

    <!--VIEW HOME COURSES-->
    @include("sistema/includes/section-courses")
    <!--VIEW HOME COURSES-->

    <!--SECTION ABOUT-->
    @include("sistema/includes/section-about")
    <!--SECTION ABOUT-->

    <!--SECTION TEACHERS-->
    @include("sistema/includes/section-teachers")
    <!--SECTION TEACHERS-->

    <section class="view_students_go_cta">
        <div class="container">
            <header class="view_students_go_cta_header">
                <span>NÃO PERCA TEMPO</span>
                <h2>Se torne um aluno <b>cadastre-se agora!</b></h2>
            </header>

            <a title="Cadastra-se" href="{{ route('sistema.vod.assinatura.index') }}">Quero me cadastrar agora!</a>
        </div>
    </section>
</section>
@stop