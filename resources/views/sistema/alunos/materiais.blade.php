@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-archive"></i> Materiais</h1>
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
    <section class="content materiais">
        <div class="container-fluid">
            <div class="row padding-left-20 xs-padding-5">
                <div class="col-12">
                    <div class="card card-primary card-border-azul">
                        <div class="card-body p-0 padding-bottom-30 padding-20">
                            <div class="row">
                                <input type="text" class="form-control input-white search" placeholder="Procure materiais em toda Guitarpedia por aqui">
                            </div>
                            <div class="row margin-top-15">
                                <div class="col-lg-3 padding-right-10 xs-padding-0">
                                    <div class="row">
                                        <label for="" class="quick text-gray text-18-pt bold">Cursos</label>
                                    </div>
                                    <div class="row select-container">
                                        {!! Form::select('curso', [null => 'SELECIONE'] + $cursos, null, ['class' => 'curso form-control input-white filtro', 'data-url' => route('sistema.alunos.get-modulos'), 'data-next' => 'modulos']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-3 padding-left-10 padding-right-10 xs-padding-0 xs-margin-top-10">
                                    <div class="row">
                                        <label for="" class="quick text-gray text-18-pt bold">Módulos</label>
                                    </div>
                                    <div class="row select-container modulos">
                                        <select name="" id="" class="form-control input-white">
                                            <option value="">SELECIONE UM CURSO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 padding-left-10 padding-right-10 xs-padding-0 xs-margin-top-10">
                                    <div class="row">
                                        <label for="" class="quick text-gray text-18-pt bold">Aulas</label>
                                    </div>
                                    <div class="row select-container aulas">
                                        <select name="" id="" class="form-control input-white">
                                            <option value="">SELECIONE UM MÓDULO</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3 padding-left-10 padding-right-10">
                                    <div class="row">
                                        <label for="" class="quick text-gray text-18-pt bold">Nível</label>
                                    </div>
                                    <div class="row select-container">
                                        <select name="" id="" class="form-control input-white">
                                            <option value="">INICIANTE</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row margin-top-15 vertical-middle quick text-gray">
                                <label for="" class="text-18-pt bold"><i class="far fa-folder-open"></i> Materiais encontrados:</label>
                                <label for="" class="text-15-pt regular padding-left-10"><span class="enc">0</span> arquivos encontrados</label>
                            </div>
                            <div class="row margin-top-10">
                                <div class="col-12 resultados padding-20 xs-padding-5">
                                </div>
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
    <script src="{{ assets('sistema/alunos/dist/js/materiais.js') }}"></script>
@stop
