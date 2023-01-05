@extends('sistema.alunos.layouts.vazio')
@section('content')

<div class="content-wrapper vazio">
    <!-- Main content -->
    <section class="content certificados-avaliacao quick">
        <div class="container-fluid">
            <div class="card card-primary card-border-azul">
                <form data-action="{{ route('sistema.alunos.vod.certificado.responder', [$certificado->id, $pergunta->id]) }}" class="form-normal">
                    <div class="card-body p-0 padding-bottom-30 padding-20">
                        <div class="row quick text-gray text-32-pt bold">
                            <i class="far fa-edit padding-right-10"></i>
                            Avaliação
                        </div>
                        <div class="row margin-top-20 text-gray text-22-pt bold">
                            {{ $certificado->curso->titulo }}
                        </div>
                        @if( $certificado->modulo()->exists())
                            <div class="row margin-top-10 text-gray text-22-pt regular">
                                {{ $certificado->modulo->titulo }}
                            </div>
                        @endif
                        <div class="row margin-top-35">
                            <span class="alert-gray text-gray text-22-pt bold">Você precisa de  {{ $certificado->acertos }}  acertos de {{ $certificado->perguntas->count() }} questões para ser aprovado</span>
                        </div>
                        <div class="col-12 questao margin-top-30">
                            <div class="row cabecalho text-white text-32-pt bold">
                                Questão {{ $pergunta->order }}
                            </div>
                            <div class="row margin-top-30 text-gray text-20-pt bold line-24">
                                {!! $pergunta->pergunta !!}
                            </div>
                            <div class="col-12 margin-top-35 respostas">
                                <input type="hidden" name="perguntacertificadovod_id" value="{{ $pergunta->pivot->id }}">
                                <div class="form-group clearfix">
                                    @foreach( range(1,5) as $x )
                                        @if( $pergunta->{'resposta_'.$x} != '' || $pergunta->{'resposta_'.$x} != null )
                                            <div class="row margin-top-5">
                                                <div class="icheck-primary d-inline text-gray text-22-pt">
                                                    <input type="radio" id="resposta_{{ $x }}" name="resposta" value="{{ $x }}" required>
                                                    <label for="resposta_{{ $x }}" class="medium">
                                                        {!! $pergunta->{'resposta_'.$x} !!}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-65">
                            <button type="submit" class="btn-purple text-20-pt semibold">Responder e Continuar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@stop

@section('content')
@stop