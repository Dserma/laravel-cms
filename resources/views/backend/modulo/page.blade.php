@extends('backend.layouts.default') 
@section('content')
<section class="content-header">
  <h1>
    Administrativo
    <small>Conteúdo da página "{{$object->title}}"</small>
  </h1>
  <ol class="breadcrumb">
    <li>
      <a href="{{route('backend.home')}}">
        <i class="fa fa-dashboard"></i> Painel Inicial</a>
    </li>
    <li class="active">Página {{$object->title}}</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <form action="#" class="form-conteudo" data-url="{{route('backend.salvar', $modelName)}}">
          <input type="hidden" name="id" value="{{$object->id}}" class="idobj" id="id">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Confira abaixo o dados da página <b>"{{$object->title}}"</b></h3>
            <button type="submit" class="btn btn-success pull-right">
                <i class="fa fa-check"></i> Salvar</button>
          </div>
          <div class="box-body">
            {{$cms::makeFields($model, $action, $object)}}
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-check"></i> Salvar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<script src="{{assets('backend/js/paginas/app.js')}}"></script>
<script>
  $(document).ready(function(){
    $('.img-editor').each(function(){
      makeImgEditor($(this));
    });
  });
</script>
@endsection