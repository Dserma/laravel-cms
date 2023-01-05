@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_home">
  <!-- CONTENT HEADER -->
  <div class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-12">
                  <h1 class="m-0" style="color: #666666;"><i class="fas fa-user-cog"></i> Painel de Controle</h1>
              </div>
          </div>
      </div>
  </div>
  <!-- CONTENT HEADER -->

  <!-- MAIN CONTENT -->
  <section class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-7">
                @if(!$usuario->aulas()->exists())
                    <div class="card card-danger card-outline">
                        <div class="card-header border-0">
                            <h5 class="m-0 text-danger text-bold">
                                <i class="fas fa-calendar-alt"></i> Instruções ao Professor
                            </h5>
                        </div>
                        <div class="card-body p-2 horizontal-center instrucoes-professor">
                            {!! $informacoes->video !!}
                        </div>
                    </div>
                @endif
                  <div class="row">
                    <div class="card card-danger card-outline">
                        <div class="card-header border-0">
                            <h5 class="m-0 text-danger text-bold">
                                <i class="fas fa-calendar-alt"></i> Minha Agenda
                            </h5>
                        </div>

                        <div class="card-body p-0">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
              </div>

              <div class="col-md-5">
                  <div class="card card-danger card-outline">
                      <div class="card-header">
                          <h5 class="m-0 text-danger text-bold">
                              <i class="fas fa-hand-holding-usd"></i> Informações Financeiras
                          </h5>
                      </div>

                      <div class="card-body">
                        <ul class="list-group margin-top-10">
                            <li class="list-group-item border rounded text-danger mb-3">
                                <div class="row justify-content-between align-items-center text-center text-md-left">
                                    <div class="col-12 col-md-auto">
                                        <div class="d-flex align-content-center">
                                            <div>Disponível para resgate</div>
                                            <button type="button" data-container="body" data-toggle="popover"
                                                    data-trigger="hover" data-placement="right"
                                                    data-title = "Disponíveis para resgate"
                                                    data-content="Valores de aulas confirmadas a mais de 30 dias.">
                                                <i class="fas fa-question-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-auto text-bold">{{ currencyToApp($resgate) }}</div>
                                </div>
                            </li>
                            <li class="list-group-item border rounded text-danger mb-3">
                                <div class="row justify-content-between align-items-center text-center text-md-left">
                                    <div class="col-12 col-md-auto">
                                        <div class="d-flex align-content-center">
                                            <div>Aulas já realizadas, a menos de 30 dias</div>
                                            <button type="button" data-container="body" data-toggle="popover"
                                                    data-trigger="hover" data-placement="right"
                                                    data-title = "Já realizadas, a menos de 30 dias"
                                                    data-content="Valores de aulas já avaliadas e liberadas, a menos de 30 dias">
                                                <i class="fas fa-question-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-auto text-bold">{{ currencyToApp($realizadas) }}</div>
                                </div>
                            </li>
                            <li class="list-group-item border rounded text-danger mb-3">
                                <div class="row justify-content-between align-items-center text-center text-md-left">
                                    <div class="col-12 col-md-auto">
                                        <div class="d-flex align-content-center">
                                            <div>Aulas ainda não realizadas</div>
                                            <button type="button" data-container="body" data-toggle="popover"
                                                    data-trigger="hover" data-placement="right"
                                                    data-title = "Não realizadas"
                                                    data-content="Valores de aulas ainda não realizadas">
                                                <i class="fas fa-question-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-auto text-bold">{{ currencyToApp($naoRealizadas) }}</div>
                                </div>
                            </li>
                            <li class="list-group-item border rounded text-danger mb-3">
                                <div class="row justify-content-between align-items-center text-center text-md-left">
                                    <div class="col-12 col-md-auto">
                                        <div class="d-flex align-content-center">
                                            <div>Bloqueado</div>
                                            <button type="button" data-container="body" data-toggle="popover"
                                                    data-trigger="hover" data-placement="right"
                                                    data-title = "Valores Bloqueados"
                                                    data-content="Valores de aulas contestadas por alunos">
                                                <i class="fas fa-question-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-auto text-bold">{{ currencyToApp($bloqueado) }}</div>
                                </div>
                            </li>
                        </ul>


                          <div class="text-right">
                              <button type="button" class="btn btn-danger text-bold" data-toggle="modal"
                                  data-target="#staticBackdrop">
                                  Solicitar Transferência <i class="fas fa-comment-dollar ml-1"></i>
                              </button>
                          </div>

                          <div class="modal fade" id="staticBackdrop" data-backdrop="static"
                          data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
                          aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-body p-4 text-left">
                                          <dl>
                                              <dt>Solicitar transferência</dt>
                                              <dd>
                                                  Deseja realmente realizar a transferência do seu saldo
                                                  disponível para sua conta bancária
                                              </dd>
                                          </dl>
                                          <div class="text-right">
                                              <button type="button" class="btn btn-sm btn-danger">Confirmar</button>
                                              <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                                                  Cancelar
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="card card-danger card-outline">
                      <div class="card-header">
                          <h5 class="m-0 text-danger text-bold">
                              <i class="fas fa-check"></i> Checklist de vendas
                          </h5>
                      </div>

                      <div class="card-body">
                          <div class="row text-14-pt bold text-red vertical-middle">
                            <div class="col-lg-8">
                                Dados pessoais
                            </div>
                            <div class="col-lg-4">
                                @if( $usuario->cpf != null )
                                    <i class="fas fa-check text-green"></i>
                                @else
                                    <i class="fas fa-ban right"></i>
                                @endif
                            </div>
                          </div>
                          <div class="row text-14-pt bold text-red vertical-middle">
                            <div class="col-lg-8">
                                Disponibilidade
                            </div>
                            <div class="col-lg-4">
                                @if( $usuario->disponibilidades()->exists() )
                                    <i class="fas fa-check text-green"></i>
                                @else
                                    <i class="fas fa-ban right"></i>
                                @endif
                            </div>
                          </div>
                          <div class="row text-14-pt bold text-red vertical-middle">
                            <div class="col-lg-8">
                                Aulas
                            </div>
                            <div class="col-lg-4">
                                @if( $usuario->aulas()->exists() )
                                    <i class="fas fa-check text-green"></i>
                                @else
                                    <i class="fas fa-ban right"></i>
                                @endif
                            </div>
                          </div>
                          <div class="row text-14-pt bold text-red vertical-middle">
                            <div class="col-lg-8">
                                Dados Financeiros
                            </div>
                            <div class="col-lg-4">
                                @if( $usuario->banco != null )
                                    <i class="fas fa-check text-green"></i>
                                @else
                                    <i class="fas fa-ban right"></i>
                                @endif
                            </div>
                          </div>
                          <div class="row text-14-pt bold text-yellow vertical-middle">
                            <div class="col-lg-8">
                                Cupons de Desconto ( opcional )
                            </div>
                            <div class="col-lg-4">
                                @if( $usuario->cupons()->exists() )
                                    <i class="fas fa-check text-green"></i>
                                @else
                                    <i class="fas fa-question-circle right"></i>
                                @endif
                            </div>
                          </div>
                          <div class="row text-14-pt bold text-yellow vertical-middle">
                            <div class="col-lg-8">
                                Pacote de Aulas ( opcional )
                            </div>
                            <div class="col-lg-4">
                                @if( $usuario->pacotes()->exists() )
                                    <i class="fas fa-check text-green"></i>
                                @else
                                    <i class="fas fa-question-circle right"></i>
                                @endif
                            </div>
                          </div>
                      </div>
                  </div>
                  @if($usuario->aulas()->exists())
                    <div class="card card-danger card-outline">
                        <div class="card-header border-0">
                            <h5 class="m-0 text-danger text-bold">
                                <i class="fas fa-calendar-alt"></i> Instruções ao Professor
                            </h5>
                        </div>
                        <div class="card-body p-2 horizontal-center instrucoes-professor">
                            {!! $informacoes->video !!}
                        </div>
                    </div>
                @endif
              </div>
          </div>
      </div>
  </section>
  <!-- MAIN CONTENT -->
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
            <a href="#" class="btn-red quick medium text-14-pt btn-reagendar submit-single-post" data-id="" data-url="" data-texto="Confirma o reagendamento desta aula?">
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
</div>
    
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/custom-ead.css') }}">
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