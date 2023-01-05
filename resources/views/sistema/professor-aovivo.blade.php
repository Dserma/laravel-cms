@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header-students")
<!--MAIN HEADER-->

<section class="view_teachers_live">
    <header class="view_teachers_live_header text-center text-xl-left">
        <div class="container padding-top-130 xs-padding-top-200">
            <div class="row xs-padding-top-30">
                <div class="col-lg-9">
                    <nav class="mb-4" aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-xl-start">
                            <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sistema.aluno.aovivo') }}">Aulas ao Vivo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $professor->present()->fullName() }}</li>
                        </ol>
                    </nav>

                    <h1>{{ $professor->present()->fullName() }}</h1>
                    <p>Agende já sua aula ao vivo com este professor</p>
                </div>
                <div class="col-lg-3 padding-top-50 xs-padding-top-20 view_teachers_live_content_promotions">
                    <div class="row price xs-horizontal-center">
                        <a href="{{ route('sistema.aluno.aovivo') }}" class="margin-top-10">OUTROS PROFESSORES</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="view_teachers_live_content">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-5 mb-5 mb-xl-0">
                    <div class="view_teachers_live_content_slides">
                        <div class="slick-photo mb-4 text-center">
                            <div>
                                <img src="{{ $professor->imagem }}" alt="">
                            </div>
                            @forelse( $professor->imagens as $i)
                                <div>
                                    <img src="{{ $professor->present()->imagem($i) }}" alt="">
                                </div>
                            @empty
                            @endforelse
                        </div>

                        <div class="slick-gallery">
                            <div>
                                <img src="{{ $professor->imagem }}" alt="">
                            </div>
                            @forelse( $professor->imagens as $i)
                                <div>
                                    <img src="{{ $professor->present()->imagem($i) }}" alt="">
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>

                    <div class="view_teachers_live_content_available">
                        <p>Disponibilidade</p>
                        @forelse($professor->disponibilidades->sortBy('order') as $d)
                            <div>{{ $professor->present()->dias($d, true) }} <span>- Das {{ $professor->present()->horas($d->hora_inicio) }} às {{ $professor->present()->horas($d->hora_fim) }}</span></div>
                        @empty
                        @endforelse
                    </div>
                    <section class="view_teachers_live_content_calendar">
                        <div class="row  horizontal-center">
                            <a href="#a" data-toggle="modal" data-target=".modal-previa">Veja a Agenda do Professor</a>
                        </div>
                    </section>

                </div>

                <div class="col-12 col-xl-7">
                    <header class="view_teachers_live_content_header">
                        <h2>Sobre o professor</h2>

                        <a href="#depoimentos">
                            <div class="evaluation">
                                <input name="rate_professor" value="{{ currencyToAppDot($professor->avaliacao) }}" class="kv-ltr-theme-svg-star rating-loading" value="0" step="0.5" dir="ltr" data-size="xs">
                                <span class="margin-left-10">{{ $professor->avaliacoes->where('ocorreu', '!=', 0)->count() }} comentários</span>
                            </div>
                        </a>

                        <ul class="tags">
                            @foreach($professor->categorias as $c)
                                <li>{{ $c->nome }}</li>
                            @endforeach
                        </ul>
                    </header>

                    <div class="row video">
                        <div class="col-12">
                            @if( $professor->video != null )
                                <iframe width="100%" height="400" src="{{ $professor->present()->embed() }}" title="" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @endif
                        </div>
                    </div>

                    <div class="view_teachers_live_content_headline">
                        {!! $professor->destaque !!}
                    </div>

                    <div class="view_teachers_live_content_resume">
                        {!! $professor->apresentacao !!}
                    </div>

                    <div class="row view_teachers_live_content_promotions">
                        <div class="col-12">
                            <div class="row semibold">
                                Preço base:
                            </div>
                            <div class="row">
                                <div class="price">
                                    @if( $aula )
                                        <p>{{ currencyToApp($aula->valor) }} / {{ $aula->duracao }} minutos</p>
                                        <a data-modal=".modal_schedule" class="margin-top-10" href="javascript: void(0)">AGENDAR AULA</a>
                                    @endif
                                </div>
                                @if( $professor->pacotes()->exists() )
                                    <div class="available">
                                        <p>Promoções disponíveis</p>
                                        @foreach( $professor->pacotes as $p )
                                            <span> {{ $p->aula->categoria->nome }} - {{ $p->quantidade }} aulas de {{ $p->aula->duracao }} min. - {{ $p->desconto }}% desconto</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="view_teachers_live_content_topics">
                        <div class="accordion" id="accordionTopics">
                            <div class="card">
                                <div class="card-header" id="headingLearn">
                                    <h2 class="mb-0">
                                        <button type="button" data-toggle="collapse" data-target="#collapseLearn" aria-expanded="true" aria-controls="collapseLearn">
                                            Mais sobre o professor <i class="fas fa-angle-down"></i>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseLearn" class="collapse show" aria-labelledby="headingLearn"
                                     data-parent="#accordionTopics">
                                    <div class="card-body">
                                        <div class="content">
                                            {!! $professor->sobre !!}
                                        </div>
                                        @if(strlen($professor->sobre) > 200)
                                            <span data-show=".content" class="read_more">[leia mais]</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if( $professor->metodo != '')
                                <div class="card">
                                    <div class="card-header" id="headMetodo">
                                        <h2 class="mb-0">
                                            <button type="button" data-toggle="collapse" data-target="#metodo" aria-expanded="true" aria-controls="metodo">
                                               Método de Ensino <i class="fas fa-angle-down"></i>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="metodo" class="collapse" aria-labelledby="headMetodo"
                                        data-parent="#accordionTopics">
                                        <div class="card-body">
                                            <div class="content">
                                                {!! $professor->metodo !!}
                                            </div>
                                            @if(strlen($professor->metodo) > 400 )
                                                <span data-show=".content" class="read_more">[leia mais]</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if( $professor->credenciais != '')
                                <div class="card">
                                    <div class="card-header" id="headCredenciais">
                                        <h2 class="mb-0">
                                            <button type="button" data-toggle="collapse" data-target="#credenciais" aria-expanded="true" aria-controls="credenciais">
                                               Credenciais e Afiliações <i class="fas fa-angle-down"></i>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="credenciais" class="collapse" aria-labelledby="headCredenciais" data-parent="#accordionTopics">
                                        <div class="card-body">
                                            <div class="content">
                                                {!! $professor->credenciais !!}
                                            </div>
                                            @if(strlen($professor->credenciais) > 400 )
                                                <span data-show=".content" class="read_more">[leia mais]</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="view_teachers_live_testemonials" id="depoimentos">
        <div class="container">
            <header class="view_teachers_live_testemonials_header">
                <i class="fas fa-comments"></i>
                <h2>Opiniões de alunos sobre o professor <b>{{ $professor->present()->fullName() }}</b></h2>
            </header>

            <div class="row">
                @forelse($professor->avaliacoes->where('exibir', 1) as $a)
                    <div class="col-12 col-md-6 col-xl-4 my-3 comentario">
                        <article>
                            <div class="description">
                                {!! $a->comentario_aluno !!}
                            </div>

                            <header>
                                <h3>{{ $a->aluno->fullName }}</h3>
                                <p>Aluno desde {{ !empty($a->aluno->created_at) ? $a->aluno->created_at->format('Y') : '' }}</p>
                                <input name="rate_professor" value="{{ currencyToAppDot($a->rate_professor) }}" class="kv-ltr-theme-svg-star rating-loading" value="0" step="0.5" dir="ltr" data-size="xs">
                            </header>
                        </article>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
</section>
    <div class="modal modal-previa" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Agenda do Professor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body table-responsive">
          
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  
@include("sistema.includes.section-cta")
@include("sistema.includes.modal-schedule")
@include("sistema.includes.modal-breve")
@stop

@section('scripts')
    <style>
        .modal-previa table{
            width: 800px;
        }
    </style>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d471cb91a9bd598"></script>
    <link href="{{ assets('sistema/alunos/dist/stars/css/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ assets('sistema/alunos/dist/stars/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <script src="{{ assets('sistema/alunos/dist/stars/js/star-rating.min.js') }}" type="text/javascript"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/themes/krajee-uni/theme.js') }}"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/js/locales/pt-BR.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($(document).width() <= 768) {
                $target = $('.view_teachers_live_content_slides').offset().top - 50;
                $('html, body').animate({ scrollTop: $target }, 800);
            }
            $('.kv-ltr-theme-svg-star').rating({
                hoverOnClear: false,
                theme: 'krajee-uni',
                language: 'pt-BR',
                showCaption: false,
                showClear: false,
                animate: false,
                readonly: true,
            });
            $('.modal-previa').on('show.bs.modal', function (event) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('sistema.aovivo.previa', $professor->id) }}",
                    success: function (response) {
                        $('.modal-previa .modal-body').html(response);
                    },
                    failure: function (response) {
                    },
                    error: function (response) {
                    }
                });
            });
        });
    </script>
@stop