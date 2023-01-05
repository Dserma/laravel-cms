@extends('backend.layouts.default') 
@section('content')
<section class="content-header">
  <h1>
    Administrativo
    <small>Imagens da página "{{$model->title}}"</small>
  </h1>
  <ol class="breadcrumb">
    <li>
      <a href="{{route('backend.home')}}">
        <i class="fa fa-dashboard"></i> Painel Inicial</a>
    </li>
    <li class="active">Página {{$model->title}}</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <form action="#" class="form-conteudo" data-url="{{route('backend.salvar', $modelName)}}">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Confira abaixo o dados da página <b>"{{$model->title}}"</b></h3>
          </div>
          <div class="box-body">
            <div class="col-lg-12 form-group">
              <label for="nome">{{$model->field}}</label>
              <input type="file" class="form-control imagem" multiple id="{{$model->field}}" name="{{$model->field}}">
            </div>
          </div>
          <div class="box-footer">
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<script src="{{assets('backend/js/paginas/app.js')}}"></script>
<script>
  var $token = "{{ csrf_token() }}";
  $(document).ready(function(){
      @php
        $galeria = [];
        foreach( $object as $g ){
          $galeria[] = $g;
        }
      @endphp
      @if( is_array( $galeria ) && !empty( $galeria ) )
        @foreach( $galeria as $v )
          var url{{$v->id}} = '{{url('storage/app/public/backend/'). '/'. $v->imagem}}';
        @endforeach
      @endif
      var $inputg = jQuery('.imagem');
      $inputg.fileinput({
        uploadExtraData: function() {
          return {
              _token: $token,
          };
        },
        @if( is_array($galeria) && !empty( $galeria ) )
          initialPreviewAsData: true,
          initialPreview: [@foreach( $galeria as $v ) url{{$v->id}},@endforeach],
          initialPreviewConfig: [
           @foreach( $galeria as $v )
            @php
              $dir = 'backend/';
              $arquivo = $dir . '/' . $v->imagem;
            @endphp
            {
              size: @php echo Storage::size($arquivo) > 0 ? Storage::size($arquivo) : 0; @endphp,
              caption: "", 
              key: {{$v->id}},
              downloadUrl: '{{ url('storage/app/public/backend/'). $v->imagem}}', 
              filename: '{{$v->imagem}}',
              extra: { _token: $token }
            },
            @endforeach
          ],
          @endif
          language: "pt-BR",
          previewFileType: 'image',
          overwriteInitial: false,
          @if( is_array( $galeria ) && !empty( $galeria ) )
            deleteUrl: "{{route('backend.gallery.apagar', strtolower(class_basename($model)))}}",
          @endif
          maxFileSize: 10000,
          showClose: false,
          showCaption: true,
          showBrowse: true,
          browseOnZoneClick: true,
          removeLabel: 'Remover',
          allowedFileTypes: ["image"],
          allowedFileExtensions: ["png", "jpg", "jpeg", "gif", "svg", "webp"],
          showUpload: false,
          uploadUrl: "{{route('backend.gallery', strtolower(class_basename($model)) )}}",
          uploadAsync: true,
          maxFileCount: 0
      });

      $inputg.on('filebeforedelete', function(jqXHR) {
          var abort = true; if (confirm("Confirma a exclusao desta imagem?")) { abort = false; } return abort;
      });

      $inputg.on("filebatchselected", function(event, files) {
          $(this).fileinput("upload"); 
      });
      
      $inputg.on('filebatchuploadcomplete', function(event, files, extra) {
        window.location.reload();
      });
  })
</script>
@endsection