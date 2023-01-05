@extends('backend.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Administrativo
        <small>Listagem de Histórico Financeiro do aluno {{$aluno->nome}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('backend.home')}}"><i class="fa fa-dashboard"></i> Painel Inicial</a></li>
        <li><a href="{{route('backend.model', class_basename($aluno))}}"><i class="fa fa-cart-plus"></i> Listagem de Histórico Financeiro</a></li>
        <li class="active">Listagem de Histórico Financeiro da Aula {{$aluno->titulo}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Confira abaixo todas o <b>Histórico Financeiro do Aluno</b> <span style="color: #cc0000; font-size:28px">{{$aluno->titulo}}</span>!</h3>
                </div>
                <div class="box-body table-responsive">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Histórico Financeiro</h3>
                        </div>
                        <div class="box-body">
                          <div class="col-xs-12">
                            <input type="file" class="galeria" name="galeria" multiple />
                          </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                  <div class="col-xs-12">
                    <a href="{{route('backend.model', class_basename($aluno))}}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Voltar</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection