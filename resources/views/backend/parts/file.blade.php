<div class="col-lg-{{$params->width}} {{ $value }}form-group">
  <label for="nome">{{$params->title}}</label>
  <input type="file" class="form-control @if( isset($params->class) ) {{$params->class}} @endif" id="file_{{$field}}" placeholder="{{$params->title}}..." name="file_{{$field}}">
</div>
<script>
  $(document).ready(function(){
    $input = $('[name="file_{{ $field }}"]');
      $input.fileinput({
        language: 'pt-BR',
        showCaption: true, 
        dropZoneEnabled: true,
        browseOnZoneClick: true,
        showUpload: false,
        showCancel: false,
        showRemove: true,
        browseLabel: 'Carregar {{ $params->title }}',
        theme: "fa",
        allowedFileTypes: [@foreach( $params->types as $p)'{{ $p }}',@endforeach],
        msgInvalidFileType: 'Tipo de arquivo inválido!". Apenas arquivos do tipo "{types}" são permitidos. O arquivo NÃO será enviado.',
      });
    })
  </script>