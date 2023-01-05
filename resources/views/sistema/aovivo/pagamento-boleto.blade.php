@extends('sistema.layouts.default')
@section('content')

<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="view_cart pagamento aovivo">
    <header class="view_cart_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="?file=courses">Ao vivo</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pagamento</li>
                </ol>
            </nav>
            <h1>Realize seu pagamento</b></h1>
        </div>
    </header>
    <div class="row margin-top-50 horizontal-center padding-bottom-50 section_courses_content">
        <a href="{{ route('sistema.alunos.aovivo.pagamentos') }}" class="load_more">Ir para meu painel</a>
    </div>
</section>
<a data-modal=".modal_boleto" href="javascript: void(0)" class="boleto text-white padding-right-20">
</a>
@include("sistema.includes.modal-boleto")
@stop
@section('scripts')
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script> 
    <script>
        $(document).ready(function(){
            $('a.boleto').click();
        })
    </script>
@stop