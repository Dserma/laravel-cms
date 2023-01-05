@extends('sistema.alunos.layouts.vazio')
@section('content')
<div class="content-wrapper vazio ver-certificado no-print">
    <!-- Main content -->
    <section class="content certificados-avaliacao-respostas quick">
        <div class="container-fluid">
            <div class="card card-primary card-border-azul">
                <div class="card-body p-0 padding-bottom-30 padding-20">
                    <div class="row quick text-gray text-32-pt bold no-print">
                            <i class="fas fa-trophy padding-right-10"></i>
                            Meu Certificado!
                    </div>
                    <div class="row margin-top-30 horizontal-center imagem">
                        <img src="{{ $certificado }}" alt="" width="80%">
                    </div>
                    <div class="row margin-top-65 no-print">
                        <a href="javascript:print()" class="btn-purple text-20-pt semibold margin-left-20">Imprimir Certificado</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<img src="{{ $certificado }}" alt="" class="print" width="100%">

@stop

@section('scripts')
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/imprime-certificado.css') }}">
@stop