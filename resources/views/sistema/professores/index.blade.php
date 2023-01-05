@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->
<section class="view_teachers">
  <header class="view_teachers_header text-center text-xl-left">
      <div class="container">
          <nav class="mb-4" aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center justify-content-xl-start">
                  <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Professores</li>
              </ol>
          </nav>

          <h1>Professores</h1>
          <p>Tem alguma dúvida? Envie para o nosso time!</p>
      </div>
  </header>

  <div class="view_teachers_list">
      <div class="container">
          <div class="row">
              <div class="col-12 col-xl-4 mb-5 mb-xl-0">
                  <div class="view_teachers_list_type mb-5">
                      <span class="title">Escolha</span>
                      <a class="blue" href="#">Aulas EAD</a>
                      <!-- <a class="red" href="#">Aulas Online</a> -->
                  </div>

                  <div class="view_teachers_list_style">
                      <span class="title">Escolha por Estilo <i class="fas fa-angle-down"></i></span>

                      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                          @foreach( $categorias as $categoria )
                            <a class="nav-link active" href="{{ route('sistema.professores.index', $categoria->slug) }}" role="tab" aria-controls="generico" aria-selected="true">
                                <i class="fas fa-chevron-right"></i> {{ $categoria->nome }}
                            </a>
                        @endforeach
                      </div>
                  </div>
              </div>

              <div class="col-12 col-xl-8">
                  <div class="tab-content" id="v-pills-tabContent">
                      <div class="tab-pane fade show active" id="generico" role="tabpanel" aria-labelledby="generico-tab">
                          <div class="row">
                              @foreach( $professores as $professor)
                                  <div class="col-6 col-md-4 mb-4 professor">
                                      <article class="text-center text-xl-left">
                                          <a class="photo" href="{{ route('sistema.professor.index', [$professor->categoria->slug, $professor->slug]) }}">
                                              <img src="{{ $professor->imagem }}" title="{{ $professor->nome }}" alt="{{ $professor->nome }}">
                                              <span class="line"></span>
                                          </a>
                                          <header>
                                              <h3>{{ $professor->nome }}</h3>
                                              <p>Professor de {{ $professor->categoria->nome }}</p>
                                          </header>
                                      </article>
                                  </div>
                              @endforeach
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