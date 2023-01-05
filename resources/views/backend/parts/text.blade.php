<div class="col-lg-{{$params->width}} form-group">
  <label for="nome">{{$params->title}}</label>
  <input type="text" @if( isset($relation) && $relation != null ) data-relation="{{ $relation }}" @endif class="form-control @if( isset($params->class) ) {{$params->class}} @endif" id="{{$field}}" placeholder="{{$params->title}}..." name="{{$field}}" value="{{ $value }}">
</div>