@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->
<section class="view_courses">
  <header class="view_courses_header text-center text-xl-left">
      <div class="container">
          <nav class="mb-4" aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center justify-content-xl-start">
                  <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Cursos</li>
              </ol>
          </nav>

          <h1>Cursos</h1>
          <p>Tenha acesso a + de 1400 aulas partir de <span>R$39,90 por mês</span></p>
      </div>
  </header>

  <div class="view_courses_content">
      <div class="container">
          <form action="" method="post">
                <div class="row">
                    <div class="col-lg-2">
                        <h2>Encontre o seu <span>curso</span></h2>
                    </div>
                    <div class="col-lg-3">
                        {!! Form::select('genero', [null => 'Gênero'] + $generos, null, ['class' => 'filtro form-control genero']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::select('nivel', [null => 'Nível'] + $niveis, null, ['class' => 'filtro form-control nivel']) !!}
                    </div>
                    <div class="col-lg-4">
                        {!! Form::select('professor', [null => 'Professor'] + $professores, null, ['class' => 'filtro form-control professor']) !!}
                    </div>
                </div>
          </form>

          <div class="row">
              <div class="col-12 col-xl-4 mb-5 mb-xl-0">
                  <div class="view_courses_content_menu">
                      <span class="title">Escolha o seu Curso <i class="fas fa-angle-down"></i></span>
                      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach( $categorias as $k => $v)
                          <a class="nav-link @if( ($categoria instanceof \App\Models\Categoriavod)  && $categoria->slug == $k ) active @endif" id="" href="{{ route('sistema.vod.index', $k) }}" role="tab" aria-controls="curso-jazz-premium" aria-selected="true">
                              Cursos de  {{ $v }} <i class="fas fa-chevron-right"></i>
                          </a>
                        @endforeach
                      </div>
                  </div>
              </div>

              <div class="col-12 col-xl-8">
                  <div class="view_courses_content_list">
                      <div class="tab-content" id="v-pills-tabContent">
                          <div class="tab-pane fade show active" id="" role="tabpanel" aria-labelledby="">
                              <div class="row lista-cursos">
                                @forelse($cursos as $curso )
                                    <div class="col-12 col-xl-4 mb-4 curso item-curso"
                                        data-genero="{{ $curso->genero->slug }}"
                                        data-nivel="{{ $curso->nivel->slug }}"
                                        data-professor="{{ $curso->professor->slug }}">
                                        <article class="text-center text-xl-left">
                                            <a class="thumb" title="{{ $curso->titulo }}" href="{{ route('sistema.vod.curso', [$curso->categoria->slug, $curso->slug]) }}">
                                                <img src="{{ $curso->imagem }}"  title="{{ $curso->titulo }}" alt="{{ $curso->titulo }}">
                                                <span>{{ $curso->professor->nome }}</span>
                                            </a>
                                            <header>
                                                <h2>{{ $curso->titulo }}</h2>
                                                <div class="details">
                                                    <p><i class="fas fa-book"></i> {{ $curso->present()->countAulas() }} aulas</p>
                                                    <p>{{ $curso->present()->countBts() }} BTs</p>
                                                </div>
                                                <a title="{{ $curso->titulo }}" href="{{ route('sistema.vod.curso', [$curso->categoria->slug, $curso->slug]) }}">Conheça o curso</a>
                                            </header>
                                        </article>
                                    </div>
                                @empty
                                @endforelse
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

    <!--SECTION CTA-->
        @include("sistema/includes/section-cta")
    <!--SECTION CTA-->
@stop
@section('scripts')
    <script src="{{ assets('sistema/alunos/dist/js/filtros-cursos.js') }}"></script>
@stop