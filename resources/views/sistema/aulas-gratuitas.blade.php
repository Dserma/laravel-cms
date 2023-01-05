@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="view_classes_free">
    <header class="view_classes_free_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Aulas Gratuitas</li>
                </ol>
            </nav>

            <h1>Aulas Gratuitas</h1>
            <p>
                <b> Comece agora mesmo a estudar
                algum assunto que sempre pensou em aprender.</b>
            </p>
        </div>
    </header>

    {{-- <div class="view_classes_free_filter">
        <div class="container">
            <form action="" method="get">
                <h2><b>Encontre o curso</b> ideal para você!</h2>

                <div class="form-row">
                    <div class="form-group col-12 col-xl-4">
                        <label for="inputLevel">Nível</label>
                        <select name="level" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="Lorem Ipsum">Lorem Ipsum</option>
                            <option value="Como ser professor">Como ser professor</option>
                            <option value="Como ser aluno">Como ser aluno</option>
                            <option value="Formas de pagamento">Formas de pagamento</option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-xl-4">
                        <label for="inputTeacher">Professor</label>
                        <select name="teacher" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="Lorem Ipsum">Lorem Ipsum</option>
                            <option value="Como ser professor">Como ser professor</option>
                            <option value="Como ser aluno">Como ser aluno</option>
                            <option value="Formas de pagamento">Formas de pagamento</option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-xl-4">
                        <label for="inputGenrer">Gênero</label>
                        <select name="genrer" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="Lorem Ipsum">Lorem Ipsum</option>
                            <option value="Como ser professor">Como ser professor</option>
                            <option value="Como ser aluno">Como ser aluno</option>
                            <option value="Formas de pagamento">Formas de pagamento</option>
                        </select>
                    </div>
                </div>

                <p>Não encontrou? <a href="#">Realize uma busca avançada!</a></p>
            </form>
        </div>
    </div> --}}

    @foreach( $categorias as $categoria )
        @if( $categoria->cursosGratuitos->count() > 0 )
            <section class="view_classes_free_list">
                <div class="container">
                    <header class="view_classes_free_list_header">
                        <h2><i class="fas fa-check-circle"></i> <span>{{ $categoria->nome }}</span> | {{  $categoria->cursosGratuitos->count()  }} Cursos</h2>
                        <p>
                            <b>O Curso Guitarpedia conta com mais de 700 aulas e é dividido em 4 níveis</b>, sendo o nível
                            iniciante feito especialmente para quem nunca tocou guitarra, ou ainda vai comprar sua primeira
                            guitarra. O Curso foi concebido com a idéia de criar uma ampla grade de matérias, tais como
                            técnica, repertório, teoria, improvisação, história etc.
                        </p>
                    </header>

                    <div class="row">
                        @foreach($categoria->cursosGratuitos->sortBy('order') as $curso)
                            <div class="col-12 col-md-6 col-xl-4 my-3">
                                <article class="text-center">
                                    <a class="thumb" href="#">
                                        <img src="{{ $curso->imagem }}" title="{{ $curso->nome }}" alt="{{ $curso->nome }}">
                                    </a>

                                    <header>
                                        <a class="category">{{ $curso->nivel->nome }}</a>
                                        <h3>{{ $curso->nome }}</h3>
                                        <div class="details">
                                            <p><i class="fas fa-book"></i> {{ $curso->present()->countAulas }} aulas</p>
                                            <p><i class="fas fa-check-circle"></i> 4 módulos</p>
                                        </div>

                                        <a class="button" href="{{ route('sistema.vod.curso', [$categoria->slug, $curso->slug]) }}">Iniciar Curso</a>
                                    </header>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach
</section>


<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop