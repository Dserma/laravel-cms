<div class="col-lg-{{$params->width}} form-group relative">
  <label for="nome">{{$params->title}}</label>
  <textarea class="form-control textarea @if( $params->editor == true ) editor @endif" placeholder="Escreva aqui..." name="{{$field}}">{{$value}}</textarea>
  @if( $params->editor == false )
    <div class="counter" data-limit="{{ $params->limit }}">0</div>
  @endif
</div>