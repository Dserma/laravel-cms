@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->
<section class="view_courses_post">
    <header class="view_courses_post_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sistema.vod.index', $curso->categoria->slug) }}">{{ $curso->categoria->nome }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $curso->titulo }}</li>
                </ol>
            </nav>

            <h1>{{ $curso->titulo }}</h1>
            <p>Aprenda {{ $curso->titulo }} com {{ $curso->professor->nome }}</p>

            <div class="details">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4 my-2 my-md-0">
                        <p><i class="fas fa-tv"></i> <span>Assista quantas vezes quiser</span></p>
                    </div>
                    <div class="col-12 col-md-4 my-2 my-md-0">
                        <p><i class="fas fa-users"></i> <span>Já são 58 alunos</span></p>
                    </div>
                    <div class="col-12 col-md-4 my-2 my-md-0">
                        <p><i class="fas fa-mobile-alt"></i> <span>Acessibilidade total</span></p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="view_courses_post_content">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-7 mb-5 mb-xl-0">
                    <div class="view_courses_post_content_description j_more_content">
                        <h2>Descrição</h2>
                      {!! $curso->descricao !!}
                        
                    </div>

                    <button data-show=".view_courses_post_content_description"
                        class="view_courses_post_content_readmore">
                        [leia mais]
                    </button>

                    <div class="view_courses_post_content_topics">
                        <div class="accordion" id="accordionTopics">
                            <div class="card">
                                <div class="card-header" id="headingLearn">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseLearn"
                                                aria-expanded="true" aria-controls="collapseLearn">
                                            O que você vai aprender neste curso: <i class="fas fa-angle-down"></i>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseLearn" class="collapse show" aria-labelledby="headingLearn"
                                     data-parent="#accordionTopics">
                                    <div class="card-body">
                                        <ul>
                                          @foreach( nlToArray($curso->aprender) as $a )
                                            <li>
                                              <i class="fas fa-check-circle"></i> 
                                              {{ $a }}
                                            </li>
                                          @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingRequirements">
                                    <h2 class="mb-0">
                                        <button class="collapsed" type="button" data-toggle="collapse"
                                                data-target="#collapseRequirements" aria-expanded="false"
                                                aria-controls="collapseRequirements">
                                            Pré-requisitos <i class="fas fa-angle-down"></i>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseRequirements" class="collapse" aria-labelledby="headingRequirements"
                                     data-parent="#accordionTopics">
                                    <div class="card-body">
                                        <ul>
                                          @foreach( nlToArray($curso->requisitos) as $a )
                                            <li>
                                              <i class="fas fa-check-circle"></i> 
                                              {{ $a }}
                                            </li>
                                          @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingCurriculum">
                                    <h2 class="mb-0">
                                        <button class="collapsed" type="button" data-toggle="collapse"
                                                data-target="#collapseCurriculum" aria-expanded="false"
                                                aria-controls="collapseCurriculum">
                                            Currículo do curso <i class="fas fa-angle-down"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseCurriculum" class="collapse" aria-labelledby="headingCurriculum"
                                     data-parent="#accordionTopics">
                                    <div class="card-body">
                                        <ul>
                                          @foreach( $curso->modulos as $a )
                                            <li>
                                              <i class="fas fa-check-circle"></i> 
                                              {{ $a->titulo }}
                                            </li>
                                          @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="view_courses_post_content_teacher">
                        <div class="photo">
                            <img src="{{ $curso->professor->imagem }}" title="{{ $curso->professor->nome }}" alt="{{ $curso->professor->nome }}">
                        </div>

                        <div class="text">
                            <h2>O professor</h2>
                            <span>{{ $curso->professor->nome }}</span>
                            {!! $curso->professor->apresentacao !!}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-5">
                    <div class="view_courses_post_content_resumed">
                        <div class="embed">
                            {!! $curso->video_apresentacao !!}
                        </div>

                        <div class="content">
                            <div class="form-group">
                                <label for="inputAccess">Escolha o acesso</label>
                                {!! Form::select('planos', [null => 'Escolha seu plano'] + $planos, null, ['class' => 'form-control planos']) !!}
                            </div>
                            <a class="subscriber" title="Faça já a sua assinatura" href="#" data-url="{{ route('sistema.vod.assinatura.index') }}">
                                Faça já a sua assinatura
                            </a>
                            <a class="experience" title="Experimente grátis" href="{{ route('sistema.aulas-gratuitas') }}">Experimente grátis</a>

                            <ul>
                                <li><i class="fas fa-check-circle"></i> Acesso total a todos os cursos</li>
                                <li><i class="fas fa-check-circle"></i> 1.400 aulas</li>
                                <li><i class="fas fa-check-circle"></i> Aulas de Guitarra, Violao, Teclado e Bateria</li>
                                <li><i class="fas fa-check-circle"></i> Aulas novas todo mes</li>
                                <li><i class="fas fa-check-circle"></i> Player exclusivo</li>
                                <li><i class="fas fa-check-circle"></i> Backing tracks, partituras etc</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="view_courses_post_related">
        <div class="container">
            <header class="view_courses_post_related_header mb-4">
                <h2>Cursos semelhantes</h2>
            </header>

            <div class="row semelhantes">
                @forelse( $semelhantes as $scurso )
                    @if($scurso->id !== $curso->id )
                        <div class="col-12 col-xl-3 my-4">
                            <article class="text-center text-xl-left">
                                <a class="thumb" title="{{ $scurso->nome }}" href="{{ route('sistema.vod.curso', [$scurso->categoria->slug, $curso->slug]) }}">
                                    <img src="{{ $scurso->imagem }}"
                                        title="{{ $scurso->nome }}" alt="{{ $scurso->nome }}">
                                    <span>{{ $scurso->professor->nome }}</span>
                                </a>

                                <header>
                                    <h2>{{ $scurso->nome }}</h2>

                                    <div class="details">
                                        <p><i class="fas fa-book"></i> {{ $scurso->present()->countAulas() }} aulas</p>
                                    </div>

                                    <a title="{{ $scurso->nome }}"  href="{{ route('sistema.vod.curso', [$scurso->categoria->slug, $scurso->slug]) }}">Conheça o curso</a>
                                </header>
                            </article>
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </section>
</section>

<!--SECTION CTA-->
@include("sistema/includes/modal-cart")
<!--SECTION CTA-->
@stop