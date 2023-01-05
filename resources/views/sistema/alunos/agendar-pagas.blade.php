@extends('sistema.alunos.layouts.default')
@section('content')

<div class="content-wrapper quick">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray text-30-pt semibold"> <i class="fas fa-laptop"></i> Aulas ao Vivo</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <!-- <div class="row horizontal-right">
                        <a href="todos-os-cursos.php" class="btn-purple text-13-pt regular"> 
                            <i class="fas fa-reply padding-right-5"></i> Voltar
                        </a>
                    </div> -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row padding-left-20 xs-padding-0">
                <div class="col-md-12">
                <button type="button" class="btn btn-default d-none btn-modal" data-toggle="modal" data-target="#modal-sm">
                </button>
                    <div class="card card-primary card-border-azul">
                        <div class="card-header-custom padding-top-10 padding-left-15 padding-right-15 padding-bottom-10 quick">
                            <h2 class="text-18-pt semibold quick"><i class="fas fa-list margin-right-15"></i> Listagem de Aulas ao Vivo Pagas</h2>
                        </div>
                        <div class="card-body p-0">

                            <div class="row padding-left-10 padding-right-10 padding-top-15 padding-bottom-25">
                                <div class="col-lg-12 grid-aulas">

                                    <div class="row text-center header">
                                        <div class="col-lg-4 padding-top-10 padding-bottom-10">
                                            Categoria
                                        </div>
                                        <div class="col-lg-4 padding-top-10 padding-bottom-10">
                                            Professor
                                        </div>
                                        <div class="col-lg-2 padding-top-10 padding-bottom-10">
                                            Duração
                                        </div>
                                        <div class="col-lg-2 padding-top-10 padding-bottom-10">
                                            Ações
                                        </div>
                                    </div>
                                @forelse( $usuario->agendamentos->where('data', null) as $agendamento )
                                    <div class="row text-center line">
                                        <div class="col-lg-4 padding-top-10 padding-bottom-10">
                                            {{ $agendamento->aula->categoria->nome }}
                                        </div>
                                        <div class="col-lg-4 padding-top-10 padding-bottom-10">
                                            {{ $agendamento->aula->professor->nome }}
                                        </div>
                                        <div class="col-lg-2 padding-top-10 padding-bottom-10">
                                            {{ $agendamento->aula->duracao }} min
                                        </div>
                                        <div class="col-lg-2 padding-5">
                                            <button class="btn btn-ver-disp" data-url="{{ route('sistema.alunos.aovivo.agendar.pagas.disponibilidade', [$agendamento->id]) }}">Agendar Aula </button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card card-primary card-border-azul card-calendario" id="calendario">
                        <div class="card-header-custom padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                            <h2 class="quick text-18-pt"><i class="fas fa-calendar-alt margin-right-15"></i> Disponibilidade do Professor</h2>
                        </div>
                        <div class="card-body p-0">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>

<div class="modal fade" id="modal-sm" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Sua Aula</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body padding-50">
          <div class="row quick text-gray text-20-pt bold">
            <span class="ini"></span> até <span class="fim"></span>
          </div>
          <div class="row margin-top-5 quick text-gray text-15-pt medium line-24">
            Aula: <span class="categoria"></span>    
          </div>
          <div class="row margin-top-5 quick text-gray text-15-pt medium line-24">
            Professor: <span class="professor"></span>
          </div>
          <div class="row margin-top-10">
            <a href="#" class="btn-green quick medium text-14-pt btn-iniciar" target="_blank" data-id="" data-url="{{ route('sistema.alunos.aovivo.aula.inicia') }}">
                <i class="fas fa-play-circle padding-right-5"></i>
                Iniciar Aula
            </a>
            <a href="{{ route('sistema.alunos.aovivo.avaliacoes') }}" class="btn-purple quick medium text-14-pt btn-avaliar d-none" target="_blank">
                <i class="fas fa-play-circle padding-right-5"></i>
                Avaliar aula
            </a>
          </div>
          <div class="row margin-top-10">
            <a href="#" class="btn-red quick medium text-14-pt btn-reagendar submit-single-post" data-url="" data-id="" data-texto="Confirma o reagendamento desta aula?">
                <i class="fas fa-edit padding-right-5"></i>
                Reagendar
            </a>
          </div>
          <div class="row margin-top-10 quick text-gray text-15-pt medium line-24">
            Possível reagendamento até 24 horas antes do ínicio previsto da aula.
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop
@section('scripts')
    <style>
        html{
            scroll-behavior: smooth;
        }
    </style>
    <script src="{{ assets('sistema/js/jquery.mask.js')}}"></script>        
    <script src="{{ assets('plugins/js/masks.js') }}"></script>      
    <script src="{{ assets('sistema/alunos/dist/js/aovivo.js') }}"></script>      

 
@stop
