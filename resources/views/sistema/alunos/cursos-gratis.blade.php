@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-coins"></i> Cursos Gratuitos</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content todos-os-cursos">
        <div class="container-fluid">
            <div class="row padding-left-20">
                <div class="col-12">
                    
                    <div class="row margin-bottom-15">
                        <div class="col-lg-12 padding-left-70 padding-right-55 barra-search filtro-interna">
                            <div class="row padding-top-15 padding-bottom-15 vertical-middle">
                                <div class="col-lg-1">
                                    <h3>Filtro</h3>
                                </div>
                                <div class="col padding-left-10 padding-right-10 select-container">
                                    {!! Form::select('categoria', [null => 'Categorias'] + $categorias, null, ['class' => 'custom-select categoria filtro']) !!}
                                </div>
                                <div class="col padding-left-10 padding-right-10 select-container">
                                    {!! Form::select('genero', [null => 'Gêneros'] + $generos, null, ['class' => 'custom-select genero filtro']) !!}
                                </div>
                                <div class="col padding-left-10 padding-right-10 select-container">
                                    {!! Form::select('nivel', [null => 'Níveis'] + $niveis, null, ['class' => 'custom-select nivel filtro']) !!}
                                </div>  
                                <div class="col padding-left-10 padding-right-10 select-container">
                                    {!! Form::select('professor', [null => 'Professores'] + $professores, null, ['class' => 'custom-select professor filtro']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card card-primary card-border-azul">
                        <div class="card-body p-0 padding-bottom-30 padding-top-10 lista-cursos">
                            @foreach( $cursos->sortBy('order') as $curso )
                            <div class="row padding-left-15 padding-top-5 padding-bottom-25 padding-right-15 info-box box-aula-ead item-curso showing"
                            data-categoria="{{ $curso->categoria->slug }}"
                            data-genero="{{ $curso->genero->slug }}"
                            data-nivel="{{ $curso->nivel->slug }}"
                            data-professor="{{ $curso->professor->slug }}">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-4 image">
                                        <div class="row">
                                            <a href="{{ route('sistema.alunos.curso-gratis', $curso->slug) }}" class="semibold">
                                                <div class="imagem" style="background-image:url('{{ $curso->imagem }}')"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 padding-left-15">
                                        <div class="row">
                                            <a href="{{ route('sistema.alunos.curso-gratis', $curso->slug) }}" class="semibold">
                                                <h4>{{ $curso->titulo }}</h4>
                                            </a>
                                        </div>
                                        <div class="row margin-top-10">
                                            <p>Nível {{ $curso->nivel->nome }}</p>
                                        </div>
                                        <div class="row margin-top-10">
                                            <p><i class="fas fa-chalkboard-teacher"></i> Professor: {{ $curso->professor->nome }}</p>
                                        </div>
                                        <div class="row margin-top-10">
                                            <div class="col-lg-auto">
                                                <div class="row vertical-middle">
                                                    <i class="fas fa-file-alt padding-right-10"></i> {{ $curso->modulos->count() }} Módulos 
                                                </div>
                                            </div>
                                            <div class="col-lg-auto padding-left-5 xs-padding-0">
                                                <div class="row vertical-middle">
                                                    <i class="fas fa-file-video padding-right-10"></i> {{ $curso->present()->countAulas() }} aulas
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row margin-top-10 vertical-middle">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 padding-left-10 padding-right-10 descricao">
                                <div class="row text-12-pt line-20">
                                    {!! $curso->resumo !!}
                                </div>
                            </div>
                            
                            <div class="col-lg-3 vertical-middle horizontal-center">
                                <div class="row padding-left-15 btn-saiba-mais">
                                    <a href="{{ route('sistema.alunos.curso-gratis', $curso->slug) }}" class="semibold">Saiba Mais</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
</div>

@stop
@section('scripts')
    <script src="{{ assets('sistema/alunos/dist/js/filtros-cursos.js') }}"></script>
@stop
