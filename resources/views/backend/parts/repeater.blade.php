<div class="col-lg-{{$params->width}} form-group repeater">
  <div class="row">
    <fieldset>
        <legend>{{$params->title}}</legend>
    </fieldset>
  </div>
  <div class="row fields" id="{{$field}}">
      {!! $fields !!}
  </div>
  <div class="row horizontal-right">
    <button type="button" data-field="{{class_basename($model)}}" class="btn btn-primary btn-novo-repeater pull-right"><i class="fa fa-plus"></i> {{$params->button}}</button>
  </div>
</div>