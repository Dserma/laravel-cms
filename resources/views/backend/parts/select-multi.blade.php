<div class="col-lg-{{$params->width}} form-group">
  <label for="nome">{{$params->title}}</label>
  <br>
  @php
    if( $params->src == 'array' ){
      $data = $params->data;
    }else{
      $data = $cms::getListToSelect($params->data, $params->show);
    }
    if( $params->json == true ){
      $value = json_decode($value);
    }
  @endphp
  {!! Form::select($field.'[]', $data, $value == null ? null : $value, ['class' => 'form-control select2 multiple', 'multiple', 'id' => $field]) !!}
</div>