@extends('sistema.alunos.layouts.default')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-star"></i> Preferidos</h1>
                </div>
                <!-- /.col -->
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content preferidos">
        <div class="container-fluid">
            <div class="row padding-left-20">
                <div class="col-sm-2">
                    <select name="tipo" class="form-control tipo" data-url="{{ route('sistema.alunos.ead.preferidos.get') }}">
                        <option value="0">Cursos</option>
                        <option value="1">Aulas</option>
                    </select>
                </div>
                <div class="col-12 margin-top-20">
                    <div class="card card-primary card-border-azul">
                        <div class="card-body p-0 padding-bottom-30 padding-20">
                            <div class="row resultados flex-column margin-top-10">
                                
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
    <script src="{{ assets('sistema/alunos/dist/js/preferidos.js') }}"></script>
@stop
