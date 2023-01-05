@extends('sistema.layouts.iframe')
@section('content')
    <section class="evolucao">
        <div class="container-fluid limit">
            <div class="row horizontal-center">
                <img src="{{ assets('sistema/images/g-evo.png') }}" alt="" class="img-responsive">
            </div>
            <div class="row text-14-pt medium flex-column conteudo padding-20 xs-text-center">
                <p>Caros alunos e parceiros do Guitarpedia:</p>

                <p>Com grande <strong>satisfa&ccedil;&atilde;o e alegria,</strong> informamos que, a partir do dia <strong>18/01/2021,</strong> a nossa plataforma ser&aacute;<strong> completamente remodelada!</strong></p>

                <p>A nova plataforma trar&aacute; um grande <strong>avan&ccedil;o na navegabilidade</strong> do site, bem como muito mais <strong>facilidades para voc&ecirc;</strong>, nosso aluno, que est&aacute; sempre conosco. Essa mudan&ccedil;a foi feita <strong>pensando em voc&ecirc;</strong>, sempre visando fornecer a<strong> melhor experi&ecirc;ncia de uso</strong>, tornando seus <strong>estudos mais f&aacute;ceis e agrad&aacute;veis.</strong></p>

                <p>Salve a data em seu calend&aacute;rio, e acompanhe conosco essa grande evolu&ccedil;&atilde;o, que contar&aacute; tamb&eacute;m com <strong>muitas novidades para as suas aulas.</strong></p>

                <p>At&eacute; breve!</p>

                <p><strong>Equipe Guitarpedia.</strong></p>

            </div>
        </div>
    </section>

@stop
@section('scripts')
    <style>
        .evolucao .conteudo strong{
            color: #ff3846 !important;
        }
    </style>
@stop