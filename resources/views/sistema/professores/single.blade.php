@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="view_teachers_post">
    <header class="view_teachers_post_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sistema.professores.index') }}">Professores</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $professor->nome }}</li>
                </ol>
            </nav>

            <h1>{{  $professor->nome  }}</h1>
            <p>Detalhes do professor</p>
        </div>
    </header>

    <div class="view_teachers_post_content">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-8 mb-5 mb-xl-0">
                    <div class="row">
                        <div class="col-12 mb-5">
                            <div class="view_teachers_post_content_about text-center text-xl-left">
                                <div class="row align-items-start">
                                    <div class="col-12 col-xl-6 mb-3 mb-xl-0">
                                        <div class="photo" style="background-image: url('{{  $professor->imagem  }}')"></div>
                                        <div class="social">
                                            @if( $professor->facebook != '')
                                                <a target="_blank" href="{{ $professor->facebook }}">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            @endif
                                            @if( $professor->instagram != '')
                                                <a target="_blank" href="{{ $professor->instagram }}">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            @endif
                                            @if( $professor->youtube != '')
                                                <a target="_blank" href="{{ $professor->youtube }}">
                                                    <i class="fab fa-youtube"></i>
                                                </a>
                                            @endif
                                            @if( $professor->twitter != '')
                                                <a target="_blank" href="{{ $professor->twitter }}">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            @endif
                                            @if( $professor->site != '')
                                                <a target="_blank" href="{{ $professor->site }}">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-xl-6 margin-top-110">
                                        <h2>Sobre o professor</h2>
                                        {!! $professor->sobre !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="view_teachers_post_content_presentation">
                                <div class="row align-items-center">
                                    <div class="col-12 col-xl-7 mb-3 mb-xl-0">
                                        <h2>Apresentação do professor</h2>
                                        {!! $professor->apresentacao !!}
                                    </div>

                                    <div class="col-12 col-xl-5">
                                        <!-- Button trigger modal -->
                                        <button class="button" type="button" data-toggle="modal" data-target="#presentation">
                                            <img src="{{ $professor->present()->thumb() }}" title="Apresentação do professor" alt="Apresentação do professor">
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="presentation" tabindex="-1" role="dialog"
                                             aria-labelledby="presentationLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Apresentação do
                                                            professor</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="embed">
                                                            <iframe width="560" height="315" src="{{ $professor->present()->embed() }}"
                                                            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="view_teachers_post_content_categories">
                        <span class="title">Outros Professores <i class="fas fa-angle-down"></i></span>
                        <div class="menu">
                            @foreach( $categorias as $categoria)
                                <a title="{{ $categoria->nome }}" href="{{ route('sistema.professores.index', $categoria->slug) }}">
                                    <i class="fas fa-chevron-right"></i> {{ $categoria->nome }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="view_teachers_post_classes">
        <div class="container">
            <header class="view_teachers_post_classes_header text-center mb-4">
                <h2>Cursos com o professor</h2>
                <p>Veja abaixo</p>
            </header>

            <div class="view_teachers_post_classes_list">
                <div class="row">
                    @foreach($professor->cursos as $curso)
                        <div class="col-12 col-xl-4 my-4">
                            <article class="text-center">
                                <a class="thumb" href="{{ route('sistema.vod.curso', [$curso->categoria->slug, $curso->slug]) }}">
                                    <img src="{{ $curso->imagem }}" title="{{ $curso->titulo }}" alt="{{ $curso->titulo }}">
                                </a>

                                <header>
                                    <a href="{{ route('sistema.vod.index', $curso->categoria->slug) }}">{{ $curso->categoria->nome }}</a>
                                    <h3>{{ $curso->titulo }}</h3>
                                </header>
                                <a class="schedule" href="{{ route('sistema.vod.curso', [$curso->categoria->slug, $curso->slug]) }}">Conhecer curso</a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</section>
<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop