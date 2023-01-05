<!DOCTYPE html>
<html lang="pt-br">
    <head>
        @yield('lomade')
        <!-- Google Tag Manager -->
        </script>
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-PTF8XG');
        </script>
        <!-- End Google Tag Manager -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
        @if( isset($curso) && $curso != null )
            <meta name="description" content="{{ $curso->keywords }}">
        @endif
        <title>Guitarpedia - Ensino Musical On-line</title>
        <link rel="icon" type="image/png" href="{{assets('sistema/images/logos/favicon.png')}}"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="{{assets('sistema/icons/fontawesome/all.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/slides/slick.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/slides/slick-theme.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/css/commom.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/css/style.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/fullcalendar/main.min.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/fullcalendar-daygrid/main.min.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/fullcalendar-timegrid/main.min.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/fullcalendar-bootstrap/main.min.css')}}"/>
        <link rel="stylesheet" href="{{assets('sistema/css/responsive.css')}}"/>
        <!-- Facebook Pixel Code -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '174650476585021'); 
            fbq('track', 'PageView');
            </script>
            <noscript>
            <img height="1" width="1" 
            src="https://www.facebook.com/tr?id=174650476585021&ev=PageView
            &noscript=1"/>
            </noscript>
        <!-- End Facebook Pixel Code -->
		<!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-YWF2ZN6FP1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-YWF2ZN6FP1');
        </script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d471cb91a9bd598"></script>
        <!-- On landing page only or each page-->
        <script src="https://static.indoleads.com/js/platform/handle.js"></script>
        <!-- /  On landing page only or each page-->
        <script src="https://static.indoleads.com/js/platform/container_v2.min.js"></script>
        <script>
            window.INDOLEADS_LIB = window.INDOLEADS_LIB || [];
            window.INDOLEADS_LIB.push({
                offer_id: 11170,
                network: "https://static.indoleads.com"
            });
        </script>
    </head>

    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTF8XG"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
      @yield('content')
    <!--MAIN FOOTER-->
    <footer class="main_footer">
        <div class="main_footer_logo">
            <div class="container">
                <a title="Guitarpedia - Ensino Musical On-line" href="{{ route('sistema.index') }}">
                    <img src="{{assets('sistema/images/logos/logo-guitarpedia-dark.png')}}"
                         title="Guitarpedia - Ensino Musical On-line"
                         alt="Guitarpedia - Ensino Musical On-line">
                </a>
            </div>
        </div>

        <div class="main_footer_middle">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-4 mb-4 mb-xl-0">
                        <div class="main_footer_middle_menu text-center text-xl-left">
                            <div class="row justify-content-center justify-content-xl-start">
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Aulas gratuitas" href="{{ route('sistema.aulas-gratuitas') }}">Aulas gratuitas</a>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Planos" href="{{ route('sistema.planos') }}">Planos</a>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Quem somos" href="{{ route('sistema.quem-somos') }}">Quem somos</a>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Blog" href="https://blog.guitarpedia.com.br" target="_blank">Blog</a>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Ajuda" href="{{ route('sistema.ajuda') }}">Ajuda</a>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Política" href="{{ route('sistema.politica') }}">Política</a>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Termos de Uso" href="{{ route('sistema.termos') }}">Termos de Uso</a>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <a title="Guitarpedia | Contato" href="{{ route('sistema.contato') }}">Contato</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-8">
                        <div class="main_footer_middle_contacts">
                            <div class="row justify-content-center justify-content-xl-start">
                                {{--  <div class="col-12 col-xl-6">
                                    <div class="main_footer_middle_contacts_item">
                                        <div class="icon"><i class="fas fa-phone"></i></div>
                                        <div class="text">
                                            <span>Ligue para nós</span>
                                            <p>{{ $configs->ligue }}</p>
                                        </div>
                                    </div>
                                </div>  --}}

                                <div class="col-12 col-xl-6">
                                    <div class="main_footer_middle_contacts_item">
                                        <div class="icon"><i class="fab fa-whatsapp"></i></div>
                                        <div class="text">
                                            <span>Dê um olá no WhatsApp</span>
                                            <p><a href="https://api.whatsapp.com/send?1=pt_BR&phone=55{{ preg_replace('/[^0-9]/', '', $configs->whatsapp)}}" target="_blank">{{ $configs->whatsapp }}</a></p></div>
                                    </div>
                                </div>

                                <div class="col-12 col-xl-6">
                                    <div class="main_footer_middle_contacts_item">
                                        <div class="icon"><i class="fas fa-envelope"></i></div>
                                        <div class="text">
                                            <span>Envie-nos um e-mail</span>
                                            <p>{{ $configs->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-xl-6">
                                    <div class="main_footer_middle_contacts_item">
                                        <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                                        <div class="text">
                                            <span>Onde estamos?</span>
                                            <p>{!! $configs->endereco !!}</p>
                                            {{--  <a target="_blank" title="Como chegar na Guitarpedia"
                                               href="{{ $configs->chegar }}">
                                                Como chegar
                                            </a>  --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main_footer_copyright">
            <div class="container">
                <div class="row justify-content-center justify-content-xl-between align-items-center">
                    <div class="col-12 col-xl-auto mb-2 mb-xl-0 text-center text-xl-left">
                        <p>© 2020 - GuitarPedia - Ensino Musical Online</p>
                    </div>

                    <div class="col-12 col-xl-auto text-center text-xl-right">
                        <a target="_blank" title="Empresa especialista em Criação de sites em São Paulo desde 2001"
                           href="https://voxdigital.com.br/">Vox Digital</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--MAIN FOOTER-->

    <script src="{{assets('sistema/js/jquery.min.js')}}"></script>
    <script src="{{assets('sistema/js/jquery-ui.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="{{assets('sistema/fullcalendar/main.min.js')}}"></script>
    <script src="{{assets('sistema/fullcalendar/locales/pt-br.js')}}"></script>
    <script src="{{assets('sistema/fullcalendar-daygrid/main.min.js')}}"></script>
    <script src="{{assets('sistema/fullcalendar-timegrid/main.min.js')}}"></script>
    <script src="{{assets('sistema/fullcalendar-interaction/main.min.js')}}"></script>
    <script src="{{assets('sistema/fullcalendar-bootstrap/main.min.js')}}"></script>
    <script src="{{assets('sistema/slides/slick.min.js')}}"></script>
    <script src="{{assets('sistema/js/app.js')}}"></script>
    <script src="{{assets('sistema/js/site.js')}}"></script>
    <script src="{{assets('sistema/alunos/dist/js/aovivo.js')}}"></script>
    <link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
    <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <link rel="stylesheet" href="{{assets('node_modules/sweetalert2/dist/sweetalert2.css')}}">
    <script src="{{assets('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <div class="loader">
        <img src="{{ assets('sistema/images/load.png') }}" alt="">
    </div>
    @include("sistema.includes.modal-cart")
    </body>
</html>
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
    <script>
        var routepaypal = '{{ route('sistema.vod.paypal.sucesso') }}';
        var routes = {
            sistema:{
            aovivo:{
                atualizacart: '{{ route('sistema.aovivo.atualizacart') }}',
                atualizavalor: '{{ route('sistema.aovivo.atualizavalor') }}',
            }
            }
        };
    </script>