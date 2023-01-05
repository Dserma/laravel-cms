@php 
  if( isset($params->top) ){
    $tree = 'treeview';
  }else{
    $tree = '';
  }
@endphp
@if( $params->type == 'model' || !isset($params->type) )
  <li class="{{$tree}} @if(request()->is('backend/modulo/'.$class.'')) active menu-open @endif">
    <a href="{{route('backend.model', [$class, $params->action ?? ''])}}">
    <i class="fa {{$params->icon}}"></i>
    <span>{{$params->title}}</span>
    @if( isset($params->top) && $params->top == true )
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    @endif
  </a>
  @if( isset($params->top) && $params->top == true )
    <ul class="treeview-menu">
    @foreach( $params->subs as $k => $v )
      <li class="@if(request()->is('backend/modulo/'.$class.'/'.$k)) active @endif">
        <a href="{{route('backend.model',[$class, $k])}}">
          <i class="fa {{$v['icon']}}"></i> {{$v['title']}} </a>
      </li>
    @endforeach
    </ul>
  @endif
</li>
@else
  <li class="{{$tree}} @if(request()->is('backend/modulo/'.$class.'*')) active menu-open @endif">
    <a href="#" class="abrir">
    <i class="fa {{$params->icon}}"></i>
    <span>{{$params->title}}</span>
    @if( isset($params->top) && $params->top == true )
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    @endif
  </a>
  @if( isset($params->top) && $params->top == true )
    <ul class="treeview-menu">
    @foreach( $params->subs as $k => $v )
      <li class="@if(request()->is('backend/modulo/'.$k)) active @endif">
        <a href="{{route('backend.model',[$k, ''])}}">
          <i class="fa {{$v['icon']}}"></i> {{$v['title']}} </a>
      </li>
    @endforeach
    </ul>
  @endif
</li>
@endif