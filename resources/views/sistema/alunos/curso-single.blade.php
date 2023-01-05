@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-book-open"></i> Curso EAD</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 horizontal-right">
                    <a href="#" onclick="history.go(-1)" class="btn-purple quick text-13-pt bold">
                        <i class="fas fa-reply padding-right-5"></i>
                        Voltar
                </a>    
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content todos-os-cursos-single">
        <div class="container-fluid">
            <div class="row padding-left-20 xs-padding-5">         
            <div class="col-md-12 ">

                <div class="card card-primary card-border-azul">             
                <div class="card-body p-0 padding-bottom-30 padding-top-20">

                    <div class="row">
                        <div class="col-lg-6 padding-left-20 padding-right-15 detalhes-curso-interna">
                            <div class="row padding-top-25 padding-right-15 xs-padding-0 info-box box-aula-ead interna-detalhes">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4 image">
                                        <div class="imagem" style="background-image:url('{{ $curso->imagem }}')"></div>
                                    </div>        
                                    <div class="col-lg-8 padding-left-15 xs-padding-0 xs-margin-top-10">
                                        <h4>{{ $curso->titulo }}</h4>
                                        <div class="row">                        
                                            <p>Nível {{ $curso->nivel->nome }}</p>
                                        </div>                                
                                        <div class="row">{{ $curso->modulos->count() }} Módulos / {{ $curso->present()->countAulas() }} aulas </div>      
                                        <div class="row vertical-middle">
                                            <i class="fas fa-history padding-right-10"></i> {{ $curso->tempo }} horas
                                        </div>                                            
                                        <div class="row btn-iniciar-curso padding-top-100 xs-padding-top-20">
                                            <div class="col-lg-8">
                                                @if( $usuario->present()->checkAssinatura($curso) )
                                                    <a href="{{ route('sistema.alunos.vod.curso.player', [$curso->slug, $curso->modulos->first()->slug, $curso->modulos->first()->aulas->first()->slug]) }}" class="bold"><i class="fas fa-play-circle"></i> Iniciar Curso</a>
                                                @else
                                                    <a href="{{ route('sistema.alunos.plano.alterar', 'alterar') }}" class="bold"><i class="fas fa-play-circle"></i> Iniciar Curso</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                                <div class="row padding-top-15 padding-bottom-10">
                                    <h5>Descrição</h5>
                                </div>
                            </div>                                
                            </div>

                            <div class="row  padding-top-35 descritivo-curso">
                               {!! $curso->descricao !!}

                                <h5>
                                <a data-toggle="collapse" href="#descritivo1" aria-expanded="true">
                                    O que você vai aprender neste curso:
                                </a>
                                </h5>                
                                <div id="descritivo1" class="collapse show padding-15" data-parent="#accordion">
                                    <ul>
                                        @foreach( nlToArray($curso->aprender) as $a )
                                            <li>
                                              <i class="fas fa-check-circle"></i> 
                                              {{ $a }}
                                            </li>
                                          @endforeach
                                    </ul>    
                                </div>
                                <h5>
                                    <a data-toggle="collapse" href="#descritivo2" aria-expanded="false">
                                        Pré-requisitos
                                    </a>
                                </h5>                
                                <div id="descritivo2" class="collapse padding-15" data-parent="#accordion">
                                    <ul>
                                        @foreach( nlToArray($curso->requisitos) as $a )
                                            <li>
                                              <i class="fas fa-check-circle"></i> 
                                              {{ $a }}
                                            </li>
                                          @endforeach                                  
                                    </ul>    
                                </div>
                                <h5>
                                    <a data-toggle="collapse" href="#descritivo3" aria-expanded="false">
                                    Currículo do curso
                                    </a>
                                </h5>                
                                <div id="descritivo3" class="collapse padding-15" data-parent="#accordion">
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
                        <div class="col-lg-6 modulos-curso">

                            <div id="accordion"> 
                                @foreach( $curso->modulos as $modulo )
                                    <h5 class="padding-left-20 padding-right-20">
                                        <a data-toggle="collapse" href="#modulo_{{ $modulo->id }}">
                                            {{ $modulo->titulo }}
                                        </a>
                                    </h5>                
                                    <div id="modulo_{{ $modulo->id }}" class="collapse" data-parent="#accordion">
                                        <div class="row flex-column padding-left-35 padding-right-35">
                                            <div class="progress">
                                                <div class="progress-bar" style="width: {{ $modulo->present()->concluido($usuario) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="row padding-left-55 quick text-gray text-13-pt bold">
                                            {{ $modulo->present()->concluido($usuario) }} % Assistidos
                                        </div>
                                        <ul class="margin-top-10 margin-bottom-30">
                                            @foreach($modulo->aulas as $aula)
                                                @if( $usuario->present()->checkAssinatura($curso) )
                                                    <li>
                                                        <a href="{{ route('sistema.alunos.vod.curso.player', [$curso->slug, $modulo->slug, $aula->slug]) }}"> <i class="fas fa-play-circle padding-right-10"></i>{{ $aula->titulo }} </a>
                                                        @if( $aula->present()->concluida($usuario, $modulo) == 1)
                                                            <i class="fas fa-check-circle text-20-pt text-green padding-left-40" title="Concluída"></i>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="#"> <i class="fas fa-play-circle padding-right-10"></i>{{ $aula->titulo }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul> 
                                    </div>   
                                @endforeach

                            </div>

                        </div>
                    </div>     

                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->


            </div>


            </div>
            <!-- /.row -->



        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>

@stop
@section('scripts')
@stop
