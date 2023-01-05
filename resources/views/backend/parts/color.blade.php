<div class="col-lg-{{$params->width}} form-group">
    <label for="nome">{{$params->title}}</label>
  <div class="input-group colorpicker">
    <input type="text" class="form-control @if( isset($params->class) ) {{$params->class}} @endif" id="{{$field}}" placeholder="{{$params->title}}..." name="{{$field}}" value="{{$value}}">
    <div class="input-group-addon">
      <i style="background-color: rgb(148, 41, 41);"></i>
    </div>
  </div>
</div>