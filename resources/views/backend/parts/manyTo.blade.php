<div class="col-lg-{{$params->width}} form-group">
  <label for="nome">{{$params->title}}</label>
  {!! Form::select($field.'[]', $cms::getListToSelect($params->model, $params->show), null, ['id' => 'rel_'.$field, 'class' => 'form-control select2 multi', 'multiple' => true]) !!}
</div>