@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_shedule">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-calendar-alt"></i> Minha Agenda de Aulas</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT HEADER -->

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="" method="">
                        <div class="row">
                            <div class="form-group col-12 col-sm-3">
                                {{--  <select name="classes" id="inputClasses" class="form-control">
                                    <option value="Todas as Aulas">Todas as Aulas</option>
                                    <option value="Aulas a serem realizadas">Aulas a serem realizadas</option>
                                    <option value="Aulas Realizadas">Aulas Realizadas</option>
                                </select>  --}}
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-12">
                    <div class="card card-danger card-outline">
                        <div class="card-body p-0">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MAIN CONTENT -->
</div>
<button type="button" class="btn btn-default d-none btn-modal" data-toggle="modal" data-target="#modal-sm">
</button>

    <div class="modal fade text-10-pt" id="modal-sm" aria-hidden="true">
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
                Aluno: <span class="aluno"></span>
            </div>
            <div class="row margin-top-10">
                <a href="#" class="btn-green quick medium text-14-pt btn-iniciar" target="_blank" data-id="" data-url="{{ route('sistema.professor.aovivo.aula.inicia') }}">
                    <i class="fas fa-play-circle padding-right-5"></i>
                    Iniciar Aula
                </a>
            </div>
            <div class="row margin-top-10">
                <a href="#" class="btn-red quick medium text-14-pt btn-reagendar submit-single-post" data-id="" data-texto="Confirma o reagendamento desta aula?" data-url="">
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

@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/custom-ead.css') }}">
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>
    <script src="{{assets('sistema/js')}}/aovivo.js"></script>
    <script>
        if ($("#calendar").length) {
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()
    
            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');
    
            var calendar = new Calendar(calendarEl, {
                plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                'themeSystem': 'bootstrap',
                locale: 'pt-br',
                timeZone: 'America/Sao_Paulo',
                eventClick: function(info) {
                    if( info.event.extendedProps.i == true && info.event.extendedProps.r == false ){
                        new swal({
                            title: 'Oops!',
                            html: '<b>A sua aula ainda não começou!<br>Retorne no horário da aula.</b>',
                            icon: 'error',
                        }).then((result) => {
                            window.location.reload();
                        });
                        return false;
                    }
                    $('.ini').html( info.event.extendedProps.hi + '&nbsp;');
                    $('.fim').html( '&nbsp;' + info.event.extendedProps.hf);
                    $('.categoria').html('&nbsp;' + info.event.extendedProps.c);
                    $('.aluno').html('&nbsp;' + info.event.extendedProps.a);
                    $('.btn-iniciar').attr('href', info.event.extendedProps.m);
                    $('.btn-iniciar').attr('data-id', info.event.id);
                    $('.btn-reagendar').attr('data-url', '{{ route('sistema.dash-professor.aula.reagendar') }}' );
                    $('.btn-reagendar').attr('data-id', info.event.id);
                    $('.btn-reagendar').attr('data-url', info.event.extendedProps.ra);
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
                    $('.btn-modal').click();
                },
                events: [
                    @forelse( $usuario->agendamentos as $a )
                        @if( \Carbon\Carbon::createFromDate($a->data . ' ' .$a->fim)->lessThan(now()))
                            {
                                title: '\nAula: {{ optional($a->aula)->categoria->nome }} \nAluno. {{ $a->aluno ? $a->aluno->fullName : '' }}',
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
                                        a: '{{ $a->aluno->fullName }}',
                                        n: '{{ \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subDay() }}',
                                        r: {{ $a->status == 0 ? 'true' : 'false' }},
                                        i: false
                                    }
                                @endif
                            }, 
                        @else
                            @if( \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->greaterThanOrEqualTo(now()->addDays(2)))
                                {
                                    title: '\nAula: {{ $a->aula->categoria->nome }} \nAluno. {{ $a->aluno->fullName }}',
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
                                            a: '{{ $a->aluno->fullName }}',
                                            n: '{{ \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subMinutes(5) }}',
                                            r: @if( now()->lessThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subDay() ) ) true @else false @endif,
                                            i: @if( now()->greaterThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio) ) ) true @else false @endif,
                                        }
                                    @endif
                                }, 
                            @else
                                @if( \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->greaterThan(now()))
                                    {
                                        title: '\nAula: {{ $a->aula->categoria->nome }} \nAluno. {{ $a->aluno->fullName }}',
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
                                                a: '{{ $a->aluno->fullName }}',
                                                n: '{{ \Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subMinutes(5) }}',
                                                r: @if( now()->lessThan(\Carbon\Carbon::createFromDate($a->data . ' ' .$a->inicio)->subDay() ) ) true @else false @endif,
                                                i: true
                                            }
                                        @endif
                                    }, 
                                @else
                                    {
                                        title: '\nAula: {{ $a->aula->categoria->nome }} \nAluno. {{ $a->aluno->fullName }}',
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
                                                a: '{{ $a->aluno->fullName }}',
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
            });
    
    
            calendar.render();
        }
    </script>
@endsection