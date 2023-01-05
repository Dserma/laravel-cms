@extends('sistema.alunos.layouts.default')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-certificate"></i> Certificados</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <!-- <div class="row horizontal-right">
                        <a href="todos-os-cursos.php" class="btn-purple text-13-pt regular"> 
                            <i class="fas fa-reply padding-right-5"></i> Voltar
                        </a>
                    </div> -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content certificados">
        <div class="container-fluid">
            <div class="row padding-left-20">
                <div class="col-12">
                    <div class="card card-primary card-border-azul">
                        <div class="card-body p-0 padding-bottom-30 padding-20">
                            <div class="row quick text-gray text-20-pt bold">
                                Meus Cursos
                            </div>
                            <div class="col-12 resultados margin-top-10">
                                @forelse($certificados as $certificado)
                                    <div class="row padding-top-25 padding-bottom-25 item">
                                        <div class="col-lg-1">
                                            <div class="row imagem">
                                                <img src="{{ $certificado->curso->imagem }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-9 padding-left-15 quick text-gray">
                                            <div class="row text-18-pt semibold">
                                                {{ $certificado->curso->titulo }}
                                            </div>
                                            @if( $certificado->modulo()->exists() )
                                                <div class="row margin-top-10 text-20-pt semibold">
                                                    {{ $certificado->modulo->titulo }}
                                                </div>
                                            @endif
                                            <div class="row margin-top-10 text-14-pt regular vertical-middle">
                                                <i class="fas fa-chalkboard-teacher padding-right-5"></i>
                                                {{ $certificado->curso->professor->nome }}
                                            </div>
                                        </div>
                                        @if( $certificado->pivot->concluido == 1 )
                                            <div class="col-lg-2 vertical-bottom">
                                                <div class="row">
                                                    <a data-fancybox data-type="iframe" href="javascript:;" data-src="{{ route('sistema.alunos.vod.certificado.ver', $certificado->id) }}" class="quick text-15-pt semibold btn-gray">
                                                        <i class="fas fa-file-image"></i>
                                                        Ver Certificado
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-2 vertical-bottom">
                                                <div class="row">
                                                    <a data-fancybox data-type="iframe" data-src="{{ route('sistema.alunos.vod.certificado', $certificado->id) }}" href="javascript:;" class="quick text-15-pt semibold btn-purple">
                                                        <i class="fas fa-certificate"></i>
                                                        Fazer Avaliação
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@stop

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@stop