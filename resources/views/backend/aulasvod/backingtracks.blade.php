@extends('backend.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Administrativo
        <small>Listagem de Backingtracks da aula {{$produto->nome}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('backend.home')}}"><i class="fa fa-dashboard"></i> Painel Inicial</a></li>
        <li><a href="{{route('backend.model', class_basename($produto))}}"><i class="fa fa-cart-plus"></i> Listagem de Backingtracks</a></li>
        <li class="active">Listagem de Backingtracks da Aula {{$produto->titulo}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Confira abaixo todas as <b>Backingtracks da Aula</b> <span style="color: #cc0000; font-size:28px">{{$produto->titulo}}</span>!</h3>
                </div>
                <div class="box-body table-responsive">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Backingtracks</h3>
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
{{-- <link rel="stylesheet" href="{{assets('backend/plugins/fileinput/css/fileinput.min.css')}}" media="all"  type="text/css" />
<script src="{{assets('backend/plugins/fileinput/js/fileinput.min.js')}}" type="text/javascript"></script>
<script src="{{assets('backend/plugins/fileinput/js/locales/pt-BR.js')}}"></script> --}}
  <script>
    var $token = "{{ csrf_token() }}";
    $(document).ready(function(){
        @php
          $galeria = [];
          foreach( $produto->backings as $g ){
            $galeria[] = $g;
          }
        @endphp
        @if( is_array( $galeria ) && !empty( $galeria ) )
          @foreach( $galeria as $v )
            var url{{$v->id}} = '{{url('storage/app/public/backend/backingtracksvod/') .'/'. $produto->id . '/' .$v->arquivo}}';
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
                $dir = 'backend/backingtracksvod/' . $produto->id . '/';
                $arquivo = $dir . '/' . $v->arquivo;
              @endphp
              {
                size: @php echo Storage::size($arquivo) > 0 ? Storage::size($arquivo) : 0; @endphp,
                caption: "{{$v->arquivo}}", 
                filetype: 'audio/mp3',
                key: {{$v->id}},
                downloadUrl: '{{ url('storage/app/public/backend/backingtracksvod/') .'/'. $produto->id . '/' .$v->arquivo}}', 
                filename: '{{$v->arquivo}}',
                extra: { _token: $token }
              },
              @endforeach
            ],
            @endif
            language: "pt-BR",
            previewFileIcon: '<i class="fas fa-file"></i>',
            allowedPreviewTypes: ['audio'],
            preferIconicPreview: true,
            previewFileIconSettings: {
                'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
            },
            previewFileExtSettings: {
                'mp3': function(ext) {
                    return ext.match(/(mp3|wav)$/i);
                },
            },
            @if( is_array( $galeria ) && !empty( $galeria ) )
              deleteUrl: "{{route('backend.aulasvod.aulavod.backingtrack.apagar', [$produto->id])}}",
            @endif
            maxFileSize: 10000,
            showClose: false,
            showCaption: true,
            showBrowse: true,
            browseOnZoneClick: true,
            removeLabel: 'Remover',
            allowedFileTypes: ["audio"],
            allowedFileExtensions: ["mp3"],
            msgInvalidFileType: 'Tipo de arquivo inválido!". Apenas arquivos do tipo "{types}" são permitidos. O arquivo NÃO será enviado.',
            showUpload: false,
            uploadUrl: "{{route('backend.aulasvod.aulavod.backingtrack', $produto->id)}}",
            uploadAsync: true,
            maxFileCount: 0,
            theme: "fa",
        });

        $inputg.on('filebatchpreupload', function(event, data) {
            var form = data.form, files = data.files, extra = data.extra,
              response = data.response, reader = data.reader;
            console.log('File batch pre upload');
        });

        $inputg.on('filebeforedelete', function(jqXHR) {
            var abort = true; if (confirm("Confirma a exclusão deste backingtrack?")) { abort = false; } return abort;
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