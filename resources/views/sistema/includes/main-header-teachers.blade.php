<header class="main_header">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-12 col-xl-auto mb-3 mb-xl-0 text-center">
                <a title="Guitarpedia - Ensino Musical On-line" href="{{ route('sistema.index') }}" class="main_header_logo">
                    <img src="{{ assets('sistema/images/logos/logo-guitarpedia-white.png') }}" title="Guitarpedia - Ensino Musical On-line" alt="Guitarpedia - Ensino Musical On-line">
                </a>
            </div>

            <div class="col-12 col-xl-auto">
                <div class="main_header_teacher_area">
                    <b>Área</b> do professor
                </div>
            </div>

            <div class="col-12 col-xl-auto">
                <div class="main_header_auth justify-content-center justify-content-xl-between">
                    @guest
                        @if (!Auth::guard('professor')->check())
                            <div class="login">
                                <div class="drop">
                                    <i class="fas fa-lock"></i> Login
                                </div>
                                <form data-action="{{ route('sistema.login') }}" autocomplete="off" class="form-normal">
                                    <input type="hidden" name="painel" value="1">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" id="inputUser" placeholder="E-mail">
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="senha" class="form-control" id="inputPass" placeholder="Senha">
                                    </div>

                                    <div class="form-group">
                                        <a data-fancybox data-type="iframe" data-src="{{ route('sistema.recuperar-senha') }}" href="javascript:;">Esqueceu a senha?</a>
                                    </div>

                                    <button type="submit">Fazer Login</button>
                                </form>
                            </div>
                        @endif
                    @endguest
                    @auth('web')
                        <div class="login">
                            <div class="drop-menu">
                                <i class="fas fa-user"></i> Olá, {{ $usuario->nome }}
                            </div>
                            <ul class="sub">
                                <li class=""><a href="{{ route('sistema.alunos.index') }}">Meu Painel</a></li>
                                <li class=""><a href="{{ route('sistema.sair') }}">Sair</a></li>
                            </ul>
                            </form>
                        </div>
                    @endauth
                    @auth('professor')
                        <div class="login">
                            <div class="drop-menu">
                                <i class="fas fa-user"></i> Olá, {{ $usuario->nome }}
                            </div>
                            <ul class="sub">
                                <li class=""><a href="{{ route('sistema.dash-professor.index') }}">Meu Painel</a></li>
                                <li class=""><a href="{{ route('sistema.sair') }}">Sair</a></li>
                            </ul>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>