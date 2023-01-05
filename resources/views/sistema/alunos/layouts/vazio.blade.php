<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guitarpedia | Ensino Musical On-Line - Painel deo Aluno</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/fullcalendar-bootstrap/main.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/adminlte.min.css') }}">
    <!-- Vox Digital Theme style -->
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/commom.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/custom-ead.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/slick.css') }}">
    <link rel="stylesheet" href="{{ assets('sistema/alunos/dist/css/slick-theme.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ assets('sistema/alunos/plugins/summernote/summernote-bs4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->


    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ assets('sistema/alunos/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ assets('sistema/alunos/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    @yield('scripts')
    <!-- Bootstrap 4 -->
    <script src="{{ assets('sistema/alunos/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ assets('sistema/alunos/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ assets('sistema/alunos/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ assets('sistema/alunos/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ assets('sistema/alunos/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ assets('sistema/alunos/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ assets('sistema/alunos/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ assets('sistema/alunos/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ assets('sistema/alunos/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ assets('sistema/alunos/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ assets('sistema/alunos/dist/js/pages/dashboard.js') }}"></script> --}}
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ assets('sistema/alunos/dist/js/demo.js') }}"></script> --}}

    <!-- fullCalendar 2.2.5 -->
    <script src="{{ assets('sistema/alunos/plugins/fullcalendar/locales-all.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/fullcalendar-interaction/main.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ assets('sistema/alunos/dist/js/slick/slick.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/dist/js/custom.js') }}"></script>
    <script src="{{ assets('sistema/js/app.js') }}"></script>
    <link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
    <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <div class="loader">
      <img src="{{ assets('sistema/images/load.png') }}" alt="">
  </div>
</body>
</html>