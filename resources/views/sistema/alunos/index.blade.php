@extends('sistema.alunos.layouts.default')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header pl-2 pl-xl-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray title-padrao"> <i class="fas fa-user-cog"></i> Painel de Controle</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol> -->
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
            @if( !$usuario->present()->checkAssinaturaGlobal() )
                <div class="row">
                    <div class="alert alert-danger text-16-pt semibold">
                        @if( $usuario->assinatura_gateway_id == null || $usuario->assinatura_gateway_id = '' )
                            @if( $usuario->validade_assinatura == null )
                                Ainda estamos aguardando a confirmação de pagamento de sua assinatura. Enquanto isso, você poderá desfrutar de nossos cursos gratuitos.
                            @else
                                Sua assinatura EAD ainda não foi paga. Por favor, <a href="{{ route('sistema.sua-conta.pagamento') }}">clique aqui</a> para realizar o pagamento.
                            @endif
                        @else
                            @if( $usuario->validade_assinatura == null )
                                Ainda estamos aguardando a confirmação de pagamento de sua assinatura. Enquanto isso, você poderá desfrutar de nossos cursos gratuitos.
                            @else
                                Sua assinatura EAD está expirada. Por favor, <a href="{{ route('sistema.sua-conta.pagamento') }}">clique aqui</a> para realizar o pagamento.
                            @endif
                        @endif
                    </div>
                </div>
            @endif
            <div class="row pl-0 pl-xl-4">
                @if( $usuario->pedidos()->exists() )
                    <div class="col-xl-6 pr-0 pr-xl-2">
                        <div class="card card-primary card-border-azul">
                            <div class="card-header-custom padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                                <div class="row">
                                    <div class="col-1 col-md-auto mr-0 mr-md-2">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-11 col-md-auto">
                                        <h2>Minha Agenda de Aulas ao Vivo</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                @endif
                
                <div class="col-xl-6 pl-0 pl-xl-2 padding-bottom-15">
                    <div class="card card-primary card-border-azul box-eads">
                        <div class="card-header-custom padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                            <h2> <i class="fas fa-play-circle margin-right-15"></i> Últimas Aulas Assistidas</h2>
                        </div>
                        @forelse($ultimos as $curso)
                            <div class="row padding-left-15 padding-top-25 padding-bottom-25 padding-right-15 info-box box-aula-ead">
                                <div class="col-lg-3 image">
                                    <div class="imagem" style="background-image:url('{{ $curso->imagem }}')"></div>
                                </div>
                                <div class="col-lg-9 padding-left-15">
                                    <h4>{{ $curso->present()->getAulaBySlug($curso->present()->continuar($usuario)['aula'])->titulo }} </h4>
                                    <div class="row">
                                        <p>{{ $curso->present()->getModuloBySlug($curso->present()->continuar($usuario)['modulo'])->titulo }}</p>
                                    </div>
                                    <div class="row">
                                        <p><i class="fas fa-chalkboard-teacher"></i> Professor: {{ $curso->professor->nome }}</p>
                                    </div>
                                    <div class="row">
                                        <p><i class="fas fa-file-alt"></i> {{ $curso->modulos->count() }} Módulos <i class="fas fa-file-video"></i> {{ $curso->present()->countAulas() }} aulas</p>
                                    </div>
                                    <div class="row">
                                        @if( $curso->present()->preferido($usuario) == 1 )
                                            <i class="fas fa-star padding-right-5"></i> Preferido
                                        @else
                                            <a href="#p" data-url="{{ route('sistema.alunos.vod.preferido.adicionar', $curso->slug) }}" data-texto="Confirma a inclusão deste curso em seus preferidos?" class="preferido submit-single-post">
                                                <i class="far fa-star padding-right-5"></i> Preferido
                                            </a>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 padding-right-15">
                                            <p>Progresso<br/>
                                                <b>{{ $curso->present()->concluido($usuario) }}%</b>
                                            </p>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: {{ $curso->present()->concluido($usuario) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 padding-top-15">
                                            <a href="{{ route('sistema.alunos.vod.curso.player', [$curso->slug, $curso->present()->continuar($usuario)['modulo'], $curso->present()->continuar($usuario)['aula']]) }}" class="btn-roxo">Continuar Aula</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
            
            <div class="row pl-0 pl-xl-4 anuncio-home text-center">
                @if( $usuario->plano->gratuito == 1)
                    <div class="col-xl-6 pr-0 pr-xl-2">
                        <div class="row banneread padding-left-30 padding-top-50" style="background-image: url('{{ $bannerEad->imagem }}')">
                            <div class="col-lg-9 col-12 text-left text-white text-20-pt regular">
                                {!! $bannerEad->conteudo !!}
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="row margin-top-100">
                                    <a href="{{ $bannerEad->link }}" class="quick text-white text-18-pt bold">{{ $bannerEad->botao }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-xl-6 pr-0 pl-xl-2">
                    <div class="row banneread padding-left-30 padding-top-50" style="background-image: url('{{ $bannerAovivo->imagem }}')">
                        <div class="col-lg-9 col-12 text-left text-white text-20-pt regular">
                            {!! $bannerAovivo->conteudo !!}
                        </div>
                        <div class="col-lg-3 col-12">
                            <div class="row margin-top-100">
                                <a href="{{ $bannerAovivo->link }}" class="quick text-white text-18-pt bold">{{ $bannerAovivo->botao }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row pl-0 pl-xl-3 padding-top-30 d-none">
                <div class="col-lg-12">
                    <div class="row">
                        <h2 class="m-0 text-gray title-padrao"> <i class="fas fa-book-open"></i> Todos os Cursos de EAD</h2>
                    </div>
                    <div class="row margin-top-30 margin-bottom-50">
                        <div class="col-md-11 center-block">
                            <div class="row lista-cursos-ead">
                                <div class="col-lg-12 padding-left-5 padding-right-5">
                                    <div class="row box-curso-ead">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="imagem" style="background-image:url({{ assets('sistema/alunos/dist/img/Camada_13.png') }})">
                                                    <div class="professor">
                                                        Bruno Godinho
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row padding-top-25 padding-bottom-15 nome-curso">
                                                <div class="col-12 text-center">
                                                    Guitarpedia Premium
                                                </div>
                                            </div>
                                            <div class="row text-center padding-bottom-25 qtde-aulas">
                                                <div class="col-12 text-center">
                                                    <i class="fas fa-book"></i> 685 aulas
                                                </div>
                                            </div>
                                            <div class="row padding-bottom-45 link">
                                                <div class="col-12 text-center">
                                                    <a href="#">VER DETALHES</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 padding-left-5 padding-right-5">
                                    <div class="row box-curso-ead">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="imagem" style="background-image:url({{ assets('sistema/alunos/dist/img/Camada_13.png') }})">
                                                    <div class="professor">
                                                        Bruno Godinho
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row padding-top-25 padding-bottom-15 nome-curso">
                                                <div class="col-12 text-center">
                                                    Guitarpedia Premium
                                                </div>
                                            </div>
                                            <div class="row text-center padding-bottom-25 qtde-aulas">
                                                <div class="col-12 text-center">
                                                    <i class="fas fa-book"></i> 685 aulas
                                                </div>
                                            </div>
                                            <div class="row padding-bottom-45 link">
                                                <div class="col-12 text-center">
                                                    <a href="#">VER DETALHES</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 padding-left-5 padding-right-5">
                                    <div class="row box-curso-ead">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="imagem" style="background-image:url({{ assets('sistema/alunos/dist/img/Camada_13.png') }})">
                                                    <div class="professor">
                                                        Bruno Godinho
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row padding-top-25 padding-bottom-15 nome-curso">
                                                <div class="col-12 text-center">
                                                    Guitarpedia Premium
                                                </div>
                                            </div>
                                            <div class="row text-center padding-bottom-25 qtde-aulas">
                                                <div class="col-12 text-center">
                                                    <i class="fas fa-book"></i> 685 aulas
                                                </div>
                                            </div>
                                            <div class="row padding-bottom-45 link">
                                                <div class="col-12 text-center">
                                                    <a href="#">VER DETALHES</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 padding-left-5 padding-right-5">
                                    <div class="row box-curso-ead">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="imagem" style="background-image:url({{ assets('sistema/alunos/dist/img/Camada_13.png') }})">
                                                    <div class="professor">
                                                        Bruno Godinho
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row padding-top-25 padding-bottom-15 nome-curso">
                                                <div class="col-12 text-center">
                                                    Guitarpedia Premium
                                                </div>
                                            </div>
                                            <div class="row text-center padding-bottom-25 qtde-aulas">
                                                <div class="col-12 text-center">
                                                    <i class="fas fa-book"></i> 685 aulas
                                                </div>
                                            </div>
                                            <div class="row padding-bottom-45 link">
                                                <div class="col-12 text-center">
                                                    <a href="#">VER DETALHES</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 padding-left-5 padding-right-5">
                                    <div class="row box-curso-ead">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="imagem" style="background-image:url({{ assets('sistema/alunos/dist/img/Camada_13.png') }})">
                                                    <div class="professor">
                                                        Bruno Godinho
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row padding-top-25 padding-bottom-15 nome-curso">
                                                <div class="col-12 text-center">
                                                    Guitarpedia Premium
                                                </div>
                                            </div>
                                            <div class="row text-center padding-bottom-25 qtde-aulas">
                                                <div class="col-12 text-center">
                                                    <i class="fas fa-book"></i> 685 aulas
                                                </div>
                                            </div>
                                            <div class="row padding-bottom-45 link">
                                                <div class="col-12 text-center">
                                                    <a href="#">VER DETALHES</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 padding-left-5 padding-right-5">
                                    <div class="row box-curso-ead">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="imagem" style="background-image:url( {{ assets('sistema/alunos/dist/img/Camada_13.png') }} )">
                                                    <div class="professor">
                                                        Bruno Godinho
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row padding-top-25 padding-bottom-15 nome-curso">
                                                <div class="col-12 text-center">
                                                    Guitarpedia Premium
                                                </div>
                                            </div>
                                            <div class="row text-center padding-bottom-25 qtde-aulas">
                                                <div class="col-12 text-center">
                                                    <i class="fas fa-book"></i> 685 aulas
                                                </div>
                                            </div>
                                            <div class="row padding-bottom-45 link">
                                                <div class="col-12 text-center">
                                                    <a href="#">VER DETALHES</a>
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
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
</div>
<button type="button" class="btn btn-default d-none btn-modal" data-toggle="modal" data-target="#modal-sm">
</button>
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
            <a href="#" class="btn-green quick medium text-14-pt btn-iniciar" target="_blank" data-id="" data-url="{{ route('sistema.alunos.aovivo.aula.inicia') }}"    >
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
    <script src="{{assets('sistema/js')}}/aovivo.js"></script>
    <script>
        $(function() {

            $('.modal').on('hide.bs.modal', function() {
                window.location.reload();
            });

            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendarInteraction.Draggable;

            var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');

            var calendar = new Calendar(calendarEl, {
                locale: 'pt-br',
                plugins: ['bootstrap', 'dayGrid', 'timeGrid'],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                displayEventEnd: true,
                timeFormat: 'h(:mm)t',
                'themeSystem': 'bootstrap',
                events: [
                    @forelse( $usuario->agendamentos as $a )
                        @if( \Carbon\Carbon::createFromDate($a->data . ' ' .$a->fim)->lessThan(now()))
                            {
                                title: '\nAula: {{ optional($a->aula)->categoria->nome }} \nProfessor: {{ $a->professor ? $a->professor->fullName : '' }}',
                                start: '{{ $a->data }}T{{ $a->inicio }}',
                                end: '{{ $a->data }}T{{ $a->fim }}',
                                backgroundColor: '{{ $a->status == 0 ? "#8c82d9dd" : "#dc3545dd" }}', 
                                borderColor: '{{ $a->status == 0 ? "#8c82d9dd" : "#dc3545dd" }}', 
                                textColor: '#fff',
                                className: 'evento-agenda',
                                id: {{ $a->id }},
                                @if( $a->meeting != null )
                                    extendedProps: {
                                        m: '{{ $a->status == 0 ? "r" : "#" }}',
                                        hi: '{{ $a->inicio }}',
                                        hf: '{{ $a->fim }}',
                                        c: '{{ $a->aula->categoria->nome }}',
                                        p: '{{ $a->professor->fullName }}',
                                        n: '{{ \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subDay() }}',
                                        r: {{ $a->status == 0 ? 'true' : 'false' }},
                                        i: false
                                    }
                                @endif
                            }, 
                        @else
                            @if( \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->greaterThanOrEqualTo(now()->addDays(2)))
                                {
                                    title: '\nAula: {{ $a->aula->categoria->nome }} \nProfessor: {{ $a->professor->fullName }}',
                                    start: '{{ $a->data }}T{{ $a->inicio }}',
                                    end: '{{ $a->data }}T{{ $a->fim }}',
                                    backgroundColor: '#99ffff', //red
                                    borderColor: '#99ffff', //red
                                    textColor: '#666',
                                    className: 'evento-agenda',
                                    id: {{ $a->id  }},
                                    @if( $a->meeting != null )
                                        extendedProps: {
                                            m: '{{ json_decode($a->meeting)->join_url }}',
                                            hi: '{{ $a->inicio }}',
                                            hf: '{{ $a->fim }}',
                                            c: '{{ $a->aula->categoria->nome }}',
                                            p: '{{ $a->professor->fullName }}',
                                            n: '{{ \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subMinutes(5) }}',
                                            r: @if( now()->lessThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subDay() ) ) true @else false @endif,
                                            i: @if( now()->greaterThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio) ) ) true @else false @endif,
                                        }
                                    @endif
                                }, 
                            @else
                                @if( \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->greaterThan(now()))
                                    {
                                        title: '\nAula: {{ $a->aula->categoria->nome }} \nProfessor: {{ $a->professor->fullName }}',
                                        start: '{{ $a->data }}T{{ $a->inicio }}',
                                        end: '{{ $a->data }}T{{ $a->fim }}',
                                        backgroundColor: '#99ffff', //red
                                        borderColor: '#99ffff', //red
                                        textColor: '#666',
                                        className: 'evento-agenda',
                                        id: {{ $a->id  }},
                                        @if( $a->meeting != null )
                                            extendedProps: {
                                                m: '{{ json_decode($a->meeting)->join_url }}',
                                                hi: '{{ $a->inicio }}',
                                                hf: '{{ $a->fim }}',
                                                c: '{{ $a->aula->categoria->nome }}',
                                                p: '{{ $a->professor->fullName }}',
                                                n: '{{ \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subMinutes(5) }}',
                                                r: @if( now()->lessThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subDay() ) ) true @else false @endif,
                                                i: true
                                            }
                                        @endif
                                    }, 
                                @else
                                    {
                                        title: '\nAula: {{ $a->aula->categoria->nome }} \nProfessor: {{ $a->professor->fullName }}',
                                        start: '{{ $a->data }}T{{ $a->inicio }}',
                                        end: '{{ $a->data }}T{{ $a->fim }}',
                                        backgroundColor: '#99ffff', //red
                                        borderColor: '#99ffff', //red
                                        textColor: '#666',
                                        className: 'evento-agenda',
                                        id: {{ $a->id  }},
                                        @if( $a->meeting != null )
                                            extendedProps: {
                                                m: '{{ json_decode($a->meeting)->join_url }}',
                                                hi: '{{ $a->inicio }}',
                                                hf: '{{ $a->fim }}',
                                                c: '{{ $a->aula->categoria->nome }}',
                                                p: '{{ $a->professor->fullName }}',
                                                n: '{{ \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subMinutes(5) }}',
                                                r: @if( now()->lessThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subDay() ) ) true @else false @endif,
                                                i: @if( now()->greaterThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio) ) ) true @else false @endif,
                                            }
                                        @endif
                                    }, 
                                @endif
                            @endif
                        @endif
                    @empty
                    @endforelse
                ],
                eventClick: function(info) {
                    if( info.event.extendedProps.i == true && info.event.extendedProps.r == false ){
                        console.log('asdasdasd');
                        new swal({
                            title: 'Oops!',
                            html: '<b>A sua aula ainda não começou!<br>Retorne no horário da aula.</b>',
                            icon: 'error',
                        }).then((result) => {
                            window.location.reload();
                        });
                        return false;
                    }
                    if( info.event.extendedProps.m != '#' ){
                        $('.ini').html( info.event.extendedProps.hi + '&nbsp;');
                        $('.fim').html( '&nbsp;' + info.event.extendedProps.hf);
                        $('.categoria').html('&nbsp;' + info.event.extendedProps.c);
                        $('.professor').html('&nbsp;' + info.event.extendedProps.p);
                        $('.btn-iniciar').attr('href', info.event.extendedProps.m);
                        $('.btn-iniciar').attr('data-id', info.event.id);
                        $('.btn-reagendar').attr('data-url', '{{ route('sistema.alunos.aovivo.reagendar') }}' );
                        $('.btn-reagendar').attr('data-id', info.event.id);
                        if( info.event.extendedProps.i == true && info.event.extendedProps.r == false ){
                            $('.btn-iniciar').removeClass('d-none');
                        }else{
                            $('.btn-iniciar').addClass('d-none');
                        }
                        if( info.event.extendedProps.r == true ){
                            $('.btn-reagendar').removeClass('d-none');
                        }else{
                            $('.btn-reagendar').addClass('d-none');
                        }
                        $('.btn-avaliar').addClass('d-none');
                        $('.btn-modal').click();
                    }else{
                        $('.ini').html( info.event.extendedProps.hi + '&nbsp;');
                        $('.fim').html( '&nbsp;' + info.event.extendedProps.hf);
                        $('.categoria').html('&nbsp;' + info.event.extendedProps.c);
                        $('.professor').html('&nbsp;' + info.event.extendedProps.p);
                        if( info.event.extendedProps.i == true ){
                            $('.btn-iniciar').removeClass('d-none');
                        }else{
                            $('.btn-iniciar').addClass('d-none');
                        }
                        $('.btn-reagendar').addClass('d-none');
                        $('.btn-avaliar').removeClass('d-none');
                        $('.btn-modal').click();
                    }
                },
            });

            calendar.render();
            // $('#calendar').fullCalendar()
        })
    </script>
@stop