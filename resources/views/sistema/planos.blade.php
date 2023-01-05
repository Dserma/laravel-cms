@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="view_packages">
    <header class="view_packages_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Planos</li>
                </ol>
            </nav>

            <h1>Planos <b>a partir de R$39,90</b></h1>
            <p>Tenha acesso a 1400 aulas e 10 cursos</p>
            <a class="goto" href="#planos">conheça nossos planos</a>
        </div>
    </header>

    <!--VIEW HOME BENEFITS-->
    @include("sistema/includes/section-benefits")
    <!--VIEW HOME BENEFITS-->

    <section class="view_packages_list" id="planos">
        <header class="view_packages_list_header">
            <div class="container">
                <h2>Nossos <b>planos</b></h2>
            </div>
        </header>

        <div class="view_packages_list_content">
            <div class="container">
                <div class="row">
                    @foreach( $planos->where('exibir', 1) as $plano )
                        <div class="col-12 col-md-6 col-xl-3 my-4">
                            <article>
                                <header>
                                    @if( $plano->economia != '')
                                        <span class="tag">{{ $plano->economia }}</span>
                                    @endif
                                    <span class="headline">
                                        {{ $plano->nome }}
                                    </span>
                                    <p>{{ $plano->descricao }}</p>
                                </header>

                                <div class="details">
                                    <p>{{ currencyToApp($plano->valor) }}</p>
                                    <a title="Quero este" href="{{ route('sistema.vod.assinatura.index', $plano->slug) }}">Quero este</a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</section>



<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop

@section('scripts')
    <script>
        $(document).ready(function(){
            $target = $('#planos').offset().top;
            $('html, body').animate({ scrollTop: $target }, 800);
        })
    </script>
@stop