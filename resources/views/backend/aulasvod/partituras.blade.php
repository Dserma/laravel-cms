@extends('backend.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Administrativo
        <small>Listagem de Partituras da aula {{$produto->nome}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('backend.home')}}"><i class="fa fa-dashboard"></i> Painel Inicial</a></li>
        <li><a href="{{route('backend.model', class_basename($produto))}}"><i class="fa fa-cart-plus"></i> Listagem de Partituras</a></li>
        <li class="active">Listagem de Partituras da Aula {{$produto->titulo}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Confira abaixo todas as <b>Partituras da Aula</b> <span style="color: #cc0000; font-size:28px">{{$produto->titulo}}</span>!</h3>
                </div>
                <div class="box-body table-responsive">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Partituras</h3>
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
                    <a href="{{route('backend.model', class_basename($produto))}}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Voltar</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
  <script>
    var $token = "{{ csrf_token() }}";
    $(document).ready(function(){
        @php
          $galeria = [];
          foreach( $produto->partituras as $g ){
            $galeria[] = $g;
          }
        @endphp
        @if( is_array( $galeria ) && !empty( $galeria ) )
          @foreach( $galeria as $v )
            var url{{$v->id}} = '{{url('storage/app/public/backend/aulasvod/') .'/'. $produto->id . '/' .$v->arquivo}}';
          @endforeach
        @endif
        var $inputg = jQuery('.galeria');
        $inputg.fileinput({
          uploadExtraData: function() {
            return {
                _token: $token,
                produto:  '{{$produto->id}}'
            };
          },
          @if( is_array($galeria) && !empty( $galeria ) )
            initialPreviewAsData: true,
            initialPreview: [@foreach( $galeria as $v ) url{{$v->id}},@endforeach],
            initialPreviewConfig: [
             @foreach( $galeria as $v )
              @php
                $dir = 'backend/aulasvod/' . $produto->id . '/';
                $arquivo = $dir . '/' . $v->arquivo;
              @endphp
              {
                @if( Storage::exists($arquivo) )
                  size: @php echo Storage::size($arquivo) > 0 ? Storage::size($arquivo) : 0; @endphp,
                  caption: "{{$v->arquivo}}", 
                  key: {{$v->id}},
                  downloadUrl: '{{ url('storage/app/public/backend/aulasvod/') .'/'. $produto->id . '/' .$v->arquivo}}', 
                  filename: '{{$v->arquivo}}',
                  extra: { _token: $token }
                  @endif
              },
              @endforeach
            ],
            @endif
            language: "pt-BR",
            previewFileType: 'image',
            overwriteInitial: false,
            @if( is_array( $galeria ) && !empty( $galeria ) )
              deleteUrl: "{{route('backend.aulasvod.aulavod.partitura.apagar', [$produto->id])}}",
            @endif
            maxFileSize: 10000,
            showClose: false,
            showCaption: true,
            showBrowse: true,
            browseOnZoneClick: true,
            removeLabel: 'Remover',
            allowedFileTypes: ["image"],
            allowedFileExtensions: ["png", "jpg", "jpeg", "gif"],
            showUpload: false,
            uploadUrl: "{{route('backend.aulasvod.aulavod.partitura', $produto->id)}}",
            uploadAsync: true,
            maxFileCount: 0,
            purifyHtml: true,
            theme: "fa",
        });

        $inputg.on('filebeforedelete', function(jqXHR) {
            var abort = true; if (confirm("Confirma a exclusao desta partitura?")) { abort = false; } return abort;
        });

        $inputg.on("filebatchselected", function(event, files) {
          if ( $('.file-error-message').text().length == 0 ) {
            $(this).fileinput("upload");
          }
        });
        
        $inputg.on('filebatchuploadcomplete', function(event, files, extra) {
          window.location.reload();
        });
    })
  </script>

@endsection