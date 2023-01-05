@extends('sistema.alunos.layouts.default')
@section('content')

<div class="content-wrapper quick">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray text-30-pt semibold"> <i class="fas fa-calendar"></i> Minhas Aulas</h1>
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
            <div class="row padding-left-20">
                <div class="col-md-12">
                <button type="button" class="btn btn-default d-none btn-modal" data-toggle="modal" data-target="#modal-sm">
                </button>
                    <div class="card card-primary card-border-azul card-calendario" id="calendario">
                        <div class="card-header-custom padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                            <h2 class="quick text-18-pt"><i class="fas fa-calendar-alt margin-right-15"></i> Minhas Aulas</h2>
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
