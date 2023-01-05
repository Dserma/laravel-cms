@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->
<!-- Event snippet for Compra conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-1025657885/9zUvCNbUlPIBEJ2YiekD',
      'transaction_id': ''
  });
</script>

<section class="view_terms">
    <header class="view_terms_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Obrigado pelo Cadastro!</li>
                </ol>
            </nav>
            <h1>Confirmação de Cadastro</h1>
            <p>Obrigado!</p>
        </div>
    </header>

    <div class="view_terms_content margin-bottom-200">
        <div class="container padding-10">
            @if($usuario->plano->gratuito == 1 )
                <div class="row flex-column htmlchars">
                    {!! $conteudo->conteudo !!}
                </div>
                <div class="row margin-top-20">
                    <a href="{{ route('sistema.alunos.index') }}" class="btn btn-danger bold">Acessar Painel</a>
                </div>
                @else
                    <div class="row flex-column htmlchars">
                        {!! $conteudo->conteudo_pago !!}
                    </div>
                    <div class="row margin-top-20">
                        <a href="{{ route('sistema.sua-conta.pagamento') }}" class="btn btn-danger bold">Realizar Pagamento</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop