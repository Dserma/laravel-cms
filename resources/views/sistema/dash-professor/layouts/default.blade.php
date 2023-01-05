<!DOCTYPE html>
<html>
<head lang="pt-br">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Área do Professor | Painel de Controle - Guitarpedia</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/fullcalendar-bootstrap/main.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/plugins/summernote/summernote-bs4.css') }}">
    <link href="{{ assets('sistema/dash-professor/plugins/fileinput/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ assets('sistema/dash-professor/plugins/fileinput/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <!-- Google Font: Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <!-- CSS Personalize -->
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/css/commom.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/dash-professor/css/style.css') }}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YWF2ZN6FP1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-YWF2ZN6FP1');
    </script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!--WRAPPER-->
<div class="wrapper">
    <!--MAIN HEADER-->
    <nav class="main-header navbar flex-wrap navbar-expand navbar-white navbar-light">
        <div class="d-none d-md-flex justify-content-between align-items-center w-100">
            <h1><b>Área</b> do Professor | <b>Painel</b> de Controle</h1>

            <div class="profile text-right">
                <span>Bem-vindo</span>
                <p class="mb-0"><i class="fas fa-user nav-icon"></i> {{ $usuario->fullName }}</p>
            </div>
        </div>

        <ul class="navbar-nav w-100">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">MENU</a>
            </li>
            <li class="nav-item ml-auto">
                <a href="{{ route('sistema.ajuda') }}" target="_blank" class="nav-link">Dúvidas Frequentes <i class="far fa-comment ml-1"></i></a>
            </li>
        </ul>
    </nav>
    <!--MAIN HEADER-->

    <!--MAIN SIDEBAR-->
    @include('sistema.dash-professor.includes.menu')
    <!--MAIN SIDEBAR-->

    <!--CONTECNT WRAPPER-->
    <div class="content-wrapper">
       @yield('content')
    </div>
    <!--CONTECNT WRAPPER-->

    <!--CONTROL SIDEBAR-->
    <aside class="control-sidebar control-sidebar-dark"></aside>
    <!--CONTROL SIDEBAR-->
</div>
<!--WRAPPER-->

<!--JAVASCRIPT-->
<!-- jQuery -->
<script src="{{ assets('sistema/dash-professor/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ assets('sistema/dash-professor/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ assets('sistema/dash-professor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ assets('sistema/dash-professor/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ assets('sistema/dash-professor/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ assets('sistema/dash-professor/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ assets('sistema/dash-professor/plugins/moment/moment.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ assets('sistema/dash-professor/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ assets('sistema/dash-professor/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ assets('sistema/dash-professor/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ assets('sistema/dash-professor/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ assets('sistema/dash-professor/plugins/moment/moment.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/daterangepicker/locales/pt-br.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ assets('sistema/dash-professor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ assets('sistema/dash-professor/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ assets('sistema/dash-professor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ assets('sistema/dash-professor/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ assets('sistema/dash-professor/js/demo.js') }}"></script>
<!-- FLOT CHARTS -->
<script src="{{ assets('sistema/dash-professor/plugins/flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ assets('sistema/dash-professor/plugins/flot-old/jquery.flot.resize.min.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ assets('sistema/dash-professor/plugins/flot-old/jquery.flot.pie.min.js') }}"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{{ assets('sistema/dash-professor/plugins/moment/moment.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fullcalendar/main.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fullcalendar/locales/pt-br.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fullcalendar-interaction/main.min.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
<!--  File Input -->
<script src="{{ assets('sistema/dash-professor/plugins/fileinput/js/plugins/piexif.js') }}" type="text/javascript"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fileinput/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fileinput/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fileinput/js/locales/pt-BR.js') }}" type="text/javascript"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fileinput/themes/fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ assets('sistema/dash-professor/plugins/fileinput/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>
<!--  Theme Scripts -->
<script src="{{ assets('sistema/dash-professor/js/scripts.js') }}"></script>
<script src="{{ assets('sistema/js/app.js') }}"></script>
<script src="{{ assets('sistema/dash-professor/js/app.js') }}"></script>
<link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
<script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
@yield('scripts')
<!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5989f5e01b1bed47ceb039f8/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
<!--End of Tawk.to Script-->
<div class="loader">
    <img src="{{ assets('sistema/images/load.png') }}" alt="">
</div>
</body>
</html>
