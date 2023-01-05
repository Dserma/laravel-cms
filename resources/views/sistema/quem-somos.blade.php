@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
    @include("sistema/includes/main-header")
    <!--MAIN HEADER-->
<section class="view_about">
  <header class="view_about_header text-center text-xl-left">
      <div class="container">
          <nav class="mb-4" aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center justify-content-xl-start">
                  <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quem Somos</li>
              </ol>
          </nav>

          <h1>Sobre o <b>GuitarPedia</b></h1>
          {!! $sobre->sobre !!}
      </div>
  </header>

  <!--VIEW HOME ABOUT-->
  @include("sistema/includes/section-about")
  <!--VIEW HOME ABOUT-->

  <!--VIEW HOME BENEFITS-->
  @include("sistema/includes/section-benefits")
  <!--VIEW HOME BENEFITS-->

  <div class="view_about_content">
      <div class="container">
          <div class="row">
              <div class="col-12 col-xl-6 my-3 text-white text-20-pt regular line-20">
                  <article>
                      <h2>Missão</h2>
                      {!! $sobre->missao !!}
                  </article>
              </div>

              <div class="col-12 col-xl-6 my-3">
                  <article>
                      <h2>Visão</h2>
                      {!! $sobre->visao !!}
                  </article>
              </div>

              <div class="col-12 my-3">
                  <article>
                      <h2>Valores</h2>
                      {!! $sobre->valores !!}
                  </article>
              </div>
          </div>
      </div>
  </div>
</section>

<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop