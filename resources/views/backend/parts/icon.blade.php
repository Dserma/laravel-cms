<div class="form-group col-lg-12">
  <label for="nome">{{$params->title}}</label>
  <img class="img-editor icon imagem fr-fil fr-dib" src="@if( !$value || $value == '' || $value == null) {{assets('backend/images/sem-imagem.png')}} @else {{$value}} @endif" alt="Imagem"/>
  <input type="hidden" name="{{$field}}" value="" class="url-imagem" id="{{$field}}">
</div>