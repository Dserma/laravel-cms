<header>
    
    <div class="container-fluid mobile-nav">
        <div class="row">
            <div class="col-12 padding-left-35 padding-top-35 painel-menu-usuario">
                <nav>
                    <ul>
                        <li><a href=""><i class="fab fa-whatsapp margin-top-5 margin-right-5"></i> <b>WhatsApp</b> 
                            <br/>{{ $configs->whatsapp }}</a></li>
                            <li><a href="{{ route('sistema.index') }}">Home</a></li>
                            <li><a href="sobre.html">Sobre nós</a></li>
                            <li><a href="fale-conosco.html">Fale conosco</a></li>
                            <li><a href="noticias.html">Notícias</a></li>
                            <li><a href="classificados.html">Classificados</a></li>
                            <li><a href="empresas.html">Empresas</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#agendaCompras"> Agenda de Compras</a></li>
                            <li><a href="{{ route('sistema.login') }}"><i class="fas fa-user margin-top-5 margin-right-5"></i> <b>Acesse sua conta</b></a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-12">
                    <button type="menu" class="menu-toogle"><i class="fas fa-bars"></i></button>
                </div>
            </div>
        </div>
        
        
        <div class="container-fluid line-topo">
            <div class="container">
                <div class="row xs-gone">                  
                    <div class="col-lg-4 padding-top-15 padding-bottom-15 menu-topo">
                        <nav>
                            <ul>
                                <li><a href="{{ route('sistema.index') }}">Home</a></li>
                                <li><a href="{{ route('sistema.sobre') }}">Sobre nós</a></li>
                                <li><a href="{{ route('sistema.fale') }}">Fale conosco</a></li>
                            </ul>
                        </nav>
                    </div> 
                    <div class="col-lg-3 padding-top-15 padding-bottom-15 text-center whats-topo">
                        <a href=""><i class="fab fa-whatsapp margin-top-5 margin-right-5"></i> <b>WhatsApp</b> {{ $configs->whatsapp }}</a>
                    </div>  
                    <div class="col-lg-5 padding-top-15 padding-bottom-15 text-right">
                        @auth
                            <a href="{{ route('sistema.sua-conta.index') }}"><i class="fas fa-user margin-top-5 margin-right-5"></i> Bem-vindo, <b>{{ $usuario->nome }}!</b></a>
                            <a href="{{ route('sistema.logout') }}">| Sair</a>
                        @endauth
                        @guest
                            <a href="{{ route('sistema.login') }}"><i class="fas fa-user margin-top-5 margin-right-5"></i> <b>Acesse sua conta</b></a>
                        @endguest
                    </div>                 
                </div>
            </div>
        </div>
        
        <div class="container-fluid line-header">
            <div class="container">
                <div class="row padding-top-25 padding-bottom-25">
                    <div class="col-lg-2">
                        <a href="{{ route('sistema.index') }}">
                            <img src="{{assets('sistema/images')}}/logo.png" alt="Olhar Rural" />
                        </a>
                    </div>
                    <div class="col-lg-7 padding-top-30  menu-principal xs-gone padding-left-20">
                        <nav>
                            <ul>
                                <li><a href="{{ route('sistema.noticias') }}">Notícias</a></li>
                                <li><a href="{{ route('sistema.classificados.index') }}">Classificados</a></li>
                                <li><a href="{{ route('sistema.empresas') }}">Empresas</a></li>
                                @guest
                                    <li><a href="#" data-toggle="modal" data-target="#agendaCompras"> Agenda de Compras</a></li>
                                @endguest
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3 padding-top-15 padding-left-25 xs-padding-left-0">
                        @guest
                            <a href="{{ route('sistema.voce-na-olhar') }}" class="button-grey-degrade">Você na olhar Rural</a>
                        @endguest
                    </div>
                </div>            
            </div>
        </div>
    </header>