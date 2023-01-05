<header class="main-header">
  <!-- Logo -->
  <a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">
      <b>OR</b>
    </span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">
      BASE
    </span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{assets('backend/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{$user->nome}}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="{{assets('backend/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
              <p>
                {{$user->nome}}
                <small>Cadastrado em {{$user->created_at}}</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                {{--  <a href="#" class="btn btn-default btn-flat">Perfil</a>  --}}
              </div>
              <div class="pull-right">
                <a href="{{route('sair')}}" class="btn btn-default btn-flat">Sair</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
      </ul>
    </div>
  </nav>
</header>

<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{assets('backend/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{$user->nome}}</p>
        <a href="#">
          <i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">
        <b>SITE</b>
      </li>
      <li class="">
        <a href="{{route('sistema.index')}}" target="_blank">
          <i class="fa fa-globe"></i>
          <span>Ver o site</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
      <li class="header">
        <b>ADMIN</b>
      </li>
      <li class="@if(route::current()->getName() == 'backend.home') active @endif">
        <a href="{{route('backend.home')}}">
          <i class="fa fa-dashboard"></i>
          <span>Painel Inicial</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
      <li class="header">
        <b>MÓDULOS</b>
      </li>
      {{$cms::makeMenu()}}
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<script>
  $(document).ready(function(){
    $('ul.treeview-menu').each(function(){
      $(this).find('li').each(function(){
        if( $(this).hasClass('active') ){
          $(this).parents('.treeview').addClass('active');
          $(this).parents('.treeview').addClass('menu-open');
        }
      })
    })
  });
</script>