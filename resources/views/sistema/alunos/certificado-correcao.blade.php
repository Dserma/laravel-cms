@extends('sistema.alunos.layouts.vazio')
@section('content')
<div class="content-wrapper vazio">
    <!-- Main content -->
    <section class="content certificados-avaliacao-respostas quick">
        <div class="container-fluid">
            <div class="card card-primary card-border-azul">
                <div class="card-body p-0 padding-bottom-30 padding-20">
                    <div class="row quick text-gray text-32-pt bold">
                        @if( $corretas >= $certificado->acertos)
                            <i class="fas fa-trophy padding-right-10"></i>
                            Aprovado!
                        @else
                            <i class="fas fa-frown padding-right-10"></i>
                            Reprovado
                        @endif
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
                        <span class="alert-gray text-gray text-22-pt bold">Você acertou {{ $corretas }} acertos de {{ $certificado->perguntas->count() }} questões. Para ser aprovado, precisa acertar {{ $certificado->acertos }} </span>
                    </div>
                    <div class="row margin-top-30">
                            <div class="col-md-4 box-pergunta">
                                <div class="row">
                                    @foreach( $perguntas as $pergunta )
                                        <div class="col-md-11 balao @if( $pergunta->pivot->resposta !== $pergunta->correta ) wrong @endif padding-left-30 padding-right-30 balao_{{ $loop->iteration }}">
                                            <div class="row text-l-gray text-100-pt bold numero">
                                                {{ $loop->iteration }}
                                            </div>
                                            <div class="row margin-top-10 text-gray text-18-pt bold line-24 questao">
                                                {!! $pergunta->pergunta !!}
                                            </div>
                                            <div class="col-12 margin-top-30 text-purple text-18-pt regular line-24 questao explicacao margin-bottom-30">
                                                <i class="fas fa-check-circle padding-right-5"></i>
                                                {!! $pergunta->{'resposta_'.$loop->iteration} !!} 
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        <div class="col-md-8 padding-left-35 respostas">
                            @foreach( $perguntas as $pergunta )
                                @if( $pergunta->pivot->resposta === $pergunta->correta )
                                    <div class="row item vertical-middle margin-bottom-20 show-balao" data-type="r" data-target="{{ $loop->iteration }}">
                                        <span class="text-gray text-22-pt bold padding-right-10">{{ $loop->iteration }}</span>
                                        <i class="fas fa-check-circle text-20-pt padding-right-5 text text-purple"></i>
                                        <span class="text-22-pt medium">Resposta correta!</span>
                                    </div>
                                @else
                                    <div class="row item vertical-middle margin-bottom-20 show-balao" data-type="w" data-target="{{ $loop->iteration }}">
                                        <span class="text-gray text-22-pt bold padding-right-10">{{ $loop->iteration }}</span>
                                        <i class="fas fa-times-circle text-20-pt padding-right-5 text text-red"></i>
                                        <span class="text-red text-22-pt bold"> Para saber essa resposta, assista novamente as aulas</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row margin-top-65">
                        @if( $corretas < $certificado->acertos)
                            <a href="{{ route('sistema.alunos.vod.certificado.refazer', $certificado->id) }}" class="btn-gray text-20-pt semibold">Refazer a Avaliação</a>
                        @endif
                        @if( $corretas >= $certificado->acertos)
                            <a href="{{ route('sistema.alunos.vod.certificado.gerar', $certificado->id) }}" class="btn-purple text-20-pt semibold margin-left-20">Receber Certificado</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@stop

@section('scripts')
    <script src="{{ assets('sistema/alunos/dist/js/correcao-certificado.js') }}"></script>
@stop