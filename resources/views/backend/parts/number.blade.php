<div class="col-lg-{{$params->width}} form-group">
  <label for="nome">{{$params->title}}</label>
  <input type="number" min="{{$params->min}}" max="{{$params->max}}" step="{{$params->step}}" class="form-control @if( isset($params->class) ) {{$params->class}} @endif" id="{{$field}}" placeholder="{{$params->title}}..." name="{{$field}}" value="{{$value}}">
</div>