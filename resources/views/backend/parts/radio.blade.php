<div class="col-lg-{{$params->width}} form-group">
  <label for="nome">{{$params->title}}</label>
  <br>
  @php
    if( $params->src == 'array' ){
      $for = $params->data;
    }else{
      $for = $cms::getListToSelect($params->data, $params->show);
    }
  @endphp
    @foreach( $for as $k => $v )
      <input type="radio" name="{{$field}}" @if( ($params->default == $k && $value == null) || $value == $k ) checked @endif id="{{$field}}_{{$k}}" value="{{$k}}" class="form-control">
      <label for="{{$field}}_{{$k}}" class="label-radio">{{$v}}</label>
    @endforeach
</div>