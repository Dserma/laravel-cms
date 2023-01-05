<div class="col-lg-{{$params->width}} form-group" id="check_{{$field}}">
  <label for="nome">{{$params->title}}</label>
  <br>
  @php
    if( $params->src == 'array' ){
      $data = $params->data;
    }else{
      $data = $cms::getListToSelect($params->data, $params->show);
    }
  @endphp
  @foreach( $data as $k => $v )
    <div class="btn-group">
      {!! Form::checkbox($field.'[]', $k, null, ['class' => 'form-control', 'id' => $field. '_'.$k]) !!}
      <label class="padding-5" for="{{$field.'_'.$k}}" class="">{{$v}}</label>
    </div>
  @endforeach
</div>