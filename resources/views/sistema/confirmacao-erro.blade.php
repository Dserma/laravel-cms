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
                    <li class="breadcrumb-item active" aria-current="page">Confirmação de Cadastro</li>
                </ol>
            </nav>

            <h1>Confirmação de Cadastro</h1>
            <p>Algo estranho ocorreu...</p>
        </div>
    </header>

    <div class="view_terms_content">
        <div class="container">
            <div class="row htmlchars text-center horizontal-center flex-column">
                <h2 class="text-red">Ocorreu algum problema com a sua confirmação!</h2>
                <p>Parece que o seu cadastro já foi validado anteriormente.</p>
                <p>Por isso, faça o login no canto superior direito.</p>
            </div>
        </div>
    </div>
</section>

<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop