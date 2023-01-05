@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

    <section class="view_help">
        <header class="view_help_header text-center text-xl-left">
            <div class="container">
                <nav class="mb-4" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center justify-content-xl-start">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ajuda</li>
                    </ol>
                </nav>
    
                <h1>Ajuda</h1>
                <p>Tem alguma dúvida? Acesse nosso FAQ</p>
            </div>
        </header>
    
        <div class="view_help_content">
            <div class="container">
                <form action="" method="get">
                    <h2>Pesquise</h2>
                    {!! Form::select('categoria', [null => 'Categorias'] + $categorias, $request->categoria ?? null, ['class' => 'categorias']) !!}
                    <input type="text" name="termo" placeholder="Ou digite a palavra-chave" value="{{ $request->termo ?? null }}">
                    <button type="submit">Buscar</button>
                </form>
    
                <div class="row">
                   @forelse($faqs as $faq)
                        <div class="col-12">
                            <article>
                                <header>
                                    <span>{{ $faq->categoria->nome }}</span>
                                    <h2>{{ $faq->titulo }}</h2>
                                </header>
    
                                <div class="description">
                                    {!! $faq->conteudo !!}
                                </div>
                            </article>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>

<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop