<div class="col-lg-{{$params->width}} form-group">
  <label for="nome">{{$params->title}}</label>
  {!! Form::select($field, [null => 'Selecione uma opção'] + $cms::getListToSelect($params->model, $params->show, $params->id ?? null), null, ['class' => 'form-control select2']) !!}
</div>