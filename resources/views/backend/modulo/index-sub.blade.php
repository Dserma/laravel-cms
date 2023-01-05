@extends('backend.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Administrativo
        <small>Listagem de {{$model->title}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('backend.home')}}"><i class="fa fa-dashboard"></i> Painel Inicial</a></li>
        <li class="active">Listagem de {{$model->title}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Confira abaixo todos(as) os(as) <b>{{$model->title}}(s)</b> cadastrados(as)! para a <b>{{class_basename($pai)}} {{$pai->nome}}</b></h3>
                    @if( isset($model->newButton) )
                      <button class="btn btn-success pull-right btn-novo-spa" data-titulo="Cadastro de Novo {{$modelName}}"><i class="fa fa-plus"></i> {{$model->newButton}}</button>
                    @endif
                </div>
                <div class="box-body table-responsive">
                    <table class="banners-table table table-responsive table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                @if( $model->hasOrder == true )
                                  <th>#</th>
                                @endif
                                <th>id</th>
                                  {{$cms::makeTable($model)}}
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                              @if( $model->hasOrder == true )
                                <th>#</th>
                              @endif
                              <th>id</th>
                                {{$cms::makeTable($model)}}
                              <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="box-footer">
                  <a href="#" class="btn btn-primary" onclick="javascript: history.back(1)"><i class="fa fa-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade modal-spa " role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
      <div class="box box-info box-solid">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b></b></h4>
              </div>
              <form role="form" class="form-spa" data-post="{{route('backend.adicionar', $modelName)}}" data-put="{{route('backend.salvar', $modelName)}}">
                <input type="hidden" name="id" value="" class="idobj" id="id">
                <div class="modal-body">
                  <div class="box-body">
                    <input type="hidden" id="{{strtolower(class_basename($pai))}}_id" name="{{strtolower(class_basename($pai))}}_id" value="{{$pai->id}}" class="noclean">
                   {{$cms::makeFields($model)}}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
                  </div>
                </div>
              </form>
          </div><!-- /.modal-content -->
      </div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  $(document).ready(function(){
    tabela = $('.table').not('.normal').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Portuguese-Brasil.json"
      },
      "ajax": {
        "url": "{{route('backend.get.sub', [$modelName, class_basename($pai), $pai->id])}}",
        "type": "GET"
      },
      "columns": [
        @if( $model->hasOrder == true )
          { "data": "order", className: 'reorder'},
        @endif
        { "data": "id"},
        {{$cms::makeData($model)}}
        { "data": "acoes" },
      ],
      @if( isset($model->order) ) 
        "order": [
          [{{$model->order}}, "{{$model->orderDirection}}"]
        ],
      @else
        "order": [
          [0, "asc"]
        ],
      @endif
      @if( $model->hasOrder == true )
        rowReorder: {
          dataSrc: 'order',
        },
      @endif
      select: false,
      'paging': true,
      "pageLength": 100,
      'lengthChange': true,
      'searching': true,
      'ordering': true,
      'info': true,
      'autoWidth': false,
      dom: 'lBfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
    $( document ).ajaxComplete(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
    tabela.on( 'row-reordered', function ( e, diff, edit ) {
      for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
        alteraOrdem(tabela.row( diff[i].node ).data().id, diff[i].newPosition+1);
      }
      tabela.ajax.reload();
    });
    function alteraOrdem(id, pos) {
      $.ajax({
        url: '{{route('backend.reordenar', $modelName)}}',
        headers: {
          'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: {sid: Math.random, i: id, p: pos, k:'{{$pai->id}}'},
        success: function (data) {
          tabela.ajax.reload();
        },
        beforeSend: function () {
        },
        complete: function () {}
      });
    }
    
  })
</script>
@endsection