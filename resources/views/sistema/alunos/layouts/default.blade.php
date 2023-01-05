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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YWF2ZN6FP1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-YWF2ZN6FP1');
    </script>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PTF8XG');</script>
<!-- End Google Tag Manager -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTF8XG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="wrapper">
        <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light justify-content-between">
        <div class="col-auto col-xl-8">
          <h1 class="d-none d-md-block ml-2 m-xl-4 margin-top-10"><b>Área</b> do Aluno | <b>Painel</b> de Controle</h1>
          <!-- Left navbar links -->
          <ul class="navbar-nav menu-reduzir">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button">MENU</a>
            </li>
          </ul>
        </div>

        <div class="col-auto col-xl-4">
          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto menu-aluno">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item text-right">
              <a class="nav-link" data-toggle="dropdown" href="#">
                Bem-vindo<br/> <i class="fas fa-user"></i> {{ $usuario->nome }}
              </a>
            </li>
            <li class="margin-top-20 mr-2 mr-xl-3">
              <a href="{{ route('sistema.ajuda') }}" target="_blank" class="link-duvidas">Dúvidas Frequentes <i class="far fa-comment"></i></a>
            </li>
          </ul>
        </div>
      </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <div class="row padding-top-10  padding-bottom-30 padding-left-15 padding-right-15 logo-open">
                <a href="{{ route('sistema.index') }}">
                    <img src="{{ assets('sistema/alunos/dist/img/logotipo.png') }}" class="logo-aberto" alt="Guitarpedia">
                    <img src="{{ assets('sistema/alunos/dist/img/logotipo_fechado.png') }}" class="logo-fechado" alt="Guitarpedia">
                </a>
            </div>


            <!-- Sidebar -->
            <div class="sidebar sidebar-dash">

                <!-- Sidebar Menu -->
                @include('sistema.alunos.includes.menu')
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
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
    {{-- <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <div class="loader">
      <img src="{{ assets('sistema/images/load.png') }}" alt="">
  </div>
</body>
</html>
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
  <script>
    var routes = {
        sistema:{
          aovivo:{
            preagenda: '{{ route('sistema.alunos.aovivo.agendar.pagas.pre-agenda') }}',
            agendar: '{{ route('sistema.alunos.aovivo.agendar.pagas.agendar') }}',
          },
          ajax:{
            materiais: '{{ route('sistema.alunos.get-materiais') }}',
          }
        }
      };
  </script>