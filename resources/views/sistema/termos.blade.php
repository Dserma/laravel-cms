@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

    <section class="view_terms">
        <header class="view_terms_header text-center text-xl-left">
            <div class="container">
                <nav class="mb-4" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center justify-content-xl-start">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Termos de Uso</li>
                    </ol>
                </nav>

                <h1>Termos de Uso</h1>
                <p>Veja abaixo</p>
            </div>
        </header>

        <div class="view_terms_content">
            <div class="container">
                <div class="htmlchars">
                    {!! $conteudo->conteudo !!}
                </div>
            </div>
        </div>
    </section>


<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop