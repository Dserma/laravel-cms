<div class="col-lg-12">
    <h3>{{$params->title}}</h3>
    @if( isset($params->comment) )
      <small>{!! $params->comment !!}</small>
    @endif
  <hr>
</div>
