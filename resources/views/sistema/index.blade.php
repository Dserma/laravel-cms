@extends('sistema.layouts.default')
@section('content')
  <div class="view_home">
    <!--MAIN HEADER-->
    @include("sistema/includes/main-header")
    <!--MAIN HEADER-->

    <!--VIEW HOME BANNERS-->
    <div class="view_home_banners">
        <div class="slick-banner">
            @foreach($banners as $banner)
                <div>
                    <article style="background-image: url('{{ $banner->imagem }}')">
                        <div class="container">
                           {!! $banner->conteudo !!}
                            <a title="{{ $banner->botao }}" href="{{ $banner->link }}">{{ $banner->botao }}</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="view_home_banners_anchor" data-go=".section_benefits">
            <i class="fas fa-arrow-down"></i>
        </div>
    </div>
    <!--VIEW HOME BANNERS-->

    <!--SECTION BENEFITS-->
    @include("sistema/includes/section-benefits")
    <!--SECTION BENEFITS-->

    <!--SECTION COURSES-->
    @include("sistema/includes/section-courses")
    <!--SECTION COURSES-->

    <!--SECTION TESTEMONIALS-->
    @include("sistema/includes/section-testemonials")
    <!--SECTION TESTEMONIALS-->

    <!--SECTION ONLINE-->
    @include("sistema/includes/section-online")
    <!--SECTION ONLINE-->

    <!--VIEW HOME ABOUT-->
    @include("sistema/includes/section-about")
    <!--VIEW HOME ABOUT-->

    <!--VIEW HOME INCOME-->
    <!--VIEW HOME INCOME-->

    <!--SECTION TEACHERS-->
    @include("sistema/includes/section-teachers")
    <!--SECTION TEACHERS-->

    <!--SECTION BLOG-->
    {{-- @include("sistema/includes/section-blog") --}}
    <!--SECTION BLOG-->

    <!--SECTION CTA-->
    @include("sistema/includes/section-cta")
    <!--SECTION CTA-->
  </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            let searchParams = new URLSearchParams(window.location.search);
            if (searchParams.has('utm_content') ){
                let param = searchParams.get('utm_content');
                document.cookie = 'utm_content='+param;
            }else{
                document.cookie = "utm_content=; Max-Age=0";
            }
        })
    </script>
  <script>
      $(document).ready(function(){
            if ($(document).width() <= 768) {
                $('.section_courses a[data-toggle="tab"]').on('show.bs.tab', function(){
                    $target = $('.section_courses-contents').offset().top - 100;
                    $('html, body').animate({ scrollTop: $target }, 800);
                });
            }
      })
  </script>
@stop