@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header-students")
<!--MAIN HEADER-->


<section class="view_classes_online">
    <header class="view_classes_online_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Aulas Ao Vivo</li>
                </ol>
            </nav>

            <h1>Aulas <b>Ao Vivo</b></h1>
            <p>Encontre seu professor ideal para aulas ao vivo on-line</p>
        </div>
    </header>

    <div class="view_classes_online_content">
        <div class="container-fluid limit relative">
            <form class="view_classes_online_contents_search" action="{{ route('sistema.aluno.aovivo') }}" method="get">
                <div class="row vertical-middle">
                    <div class="col-lg-1">
                        <h2>Encontre o sua <span>aula</span></h2>
                    </div>
                    <div class="col-lg-4 valores">
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Preço
                            </button>
                            <div class="dropdown-menu">
                                <div class="row padding-10">
                                    <div class="col-6">
                                        <label for="" class="text-black text-12-pt">Mínimo:</label>
                                        <input type="text" name="min" class="form-control dinheiro-input-mask" value="{{ $request->min ?? null }}" placeholder="R$ 0,00">
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="text-black text-12-pt">Máximo:</label>
                                        <input type="text" name="max" class="form-control dinheiro-input-mask" value="{{ $request->max ?? null }}" placeholder="R$ 0,00">
                                    </div>
                                </div>
                            </div>
                          </div>
                    </div>
                    <div class="col-lg-3">
                        <select name="disponibilidade[]" multiple="multiple" class="form-control disp">
                            <option value="1">Segunda</option>
                            <option value="2">Terça</option>
                            <option value="3">Quarta</option>
                            <option value="4">Quinta</option>
                            <option value="5">Sexta</option>
                            <option value="6">Sábado</option>
                            <option value="0">Domingo</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" name="professor" placeholder="Nome do Professor" class="form-control" value="{{ $request->professor ?? '' }}">
                    </div>
                    <div class="col-lg-1 xs-horizontal-center">
                        <button type="submit" class="btn busca"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>

            <p class="headline">
                Todos os professores do Guitarpedia são selecionados e examinados <b>para aulas on-line.</b>
            </p>

            <div class="row">
                <div class="col-12 col-xl-4 mb-5 mb-xl-0">
                    <div class="view_classes_online_content_categories">
                        <span class="title">CATEGORIAS <i class="fas fa-angle-down"></i></span>

                        <div class="menu">
                            <a title="Todas" href="{{ route('sistema.aluno.aovivo') }}">
                                <i class="fas fa-chevron-right"></i> Todas
                            </a>
                            @foreach( $categorias as $categoria)
                                <a title="{{ $categoria->nome }}" href="{{ route('sistema.aluno.aovivo', $categoria->slug) }}">
                                    <i class="fas fa-chevron-right"></i> {{ $categoria->nome }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <form class="view_classes_online_content_filter" action="" method="get">
                        <span>Ordenar resultados por</span>

                        <select name="popular">
                            <option value="0">Padrão</option>
                            <option value="1">Mais popular</option>
                            <option value="2">Aulas Vendidas</option>
                            <option value="3">Melhor Avaliação</option>
                            <option value="4">mais Recentes</option>
                        </select>
                    </form>

                    <div class="view_classes_online_content_list lista-professores">
                        <div class="row">
                            @forelse( $professores as $professor )
                                <div class="col-12 my-4">
                                    <article class="p-5 text-center text-md-left">
                                        <div class="thumb">
                                            <img src="{{ $professor->imagem }}" title="{{ $professor->present()->fullName() }}" alt="{{ $professor->present()->fullName() }}">
                                            <div class="evaluation">
                                                <input name="rate_professor" value="{{ currencyToAppDot($professor->avaliacao) }}" class="kv-ltr-theme-svg-star rating-loading" value="0" step="0.5" dir="ltr" data-size="xs">
                                                <span>{{ $professor->avaliacoes->where('ocorreu', '!=', 0)->count() }} comentários</span>
                                            </div>
                                        </div>

                                        <header>
                                            <h2>{{ $professor->present()->fullName() }}</h2>
                                            <div class="tags">
                                                @foreach($professor->categorias->take(4) as $c)
                                                    <span class="margin-bottom-10">{{ $c->nome }}</span>
                                                @endforeach
                                            </div>
                                            {!! Str::words($professor->apresentacao,80) !!}
                                            <span class="price">{{ currencyToApp($professor->present()->valorBase()->valor) }} / {{ $professor->present()->valorBase()->duracao }} minutos</span>
                                            <a href="{{ route('sistema.aluno.aovivo.professor', $professor->slug) }}" title="AGENDAR AULA" href="?file=teachers-live">AGENDAR AULA</a>
                                        </header>
                                    </article>
                                </div>
                            @empty
                                Nenhum professor encontrado nesta categoria ainda.
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('scripts')
    <style>
        
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ assets('sistema/css/multiselect.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ assets('sistema/js/multiselect.js') }}"></script>
    <script src="{{assets('sistema/js/jquery.mask.js')}}"></script>        
    <script src="{{assets('plugins/js/masks.js')}}"></script>
    <link href="{{ assets('sistema/alunos/dist/stars/css/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ assets('sistema/alunos/dist/stars/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <script src="{{ assets('sistema/alunos/dist/stars/js/star-rating.min.js') }}" type="text/javascript"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/themes/krajee-uni/theme.js') }}"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/js/locales/pt-BR.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($(document).width() <= 768) {
                $target = $('.view_classes_online_contents_search').offset().top;
                console.log($target);
                $('html, body').animate({ scrollTop: $target }, 800);
                @if( $cat != null || !empty($request->all()) )
                    $target = $('.lista-professores').offset().top - 100;
                    $('html, body').animate({ scrollTop: $target }, 800);
                @endif
            }
            $('.disp').multiselect({
                nonSelectedText: 'Disponibilidade'
            });
            $('.kv-ltr-theme-svg-star').rating({
                hoverOnClear: false,
                theme: 'krajee-uni',
                language: 'pt-BR',
                showCaption: false,
                showClear: false,
                animate: false,
                readonly: true,
            });
            @if(isset($request->disponibilidade) && is_array($request->disponibilidade))
                @foreach($request->disponibilidade as $d)
                    $('.disp option[value="{{ $d }}"]').prop('selected', true);
                @endforeach
                $('.disp').multiselect('refresh');
            @endif
        });
    </script>
@stop