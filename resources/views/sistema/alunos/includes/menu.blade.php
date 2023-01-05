<nav class="mt-2 menu-lateral">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item @if(request()->is('aluno/painel')) active @endif">
            <a href="{{ route('sistema.alunos.index') }}" class="nav-link">
                <i class="fas fa-user-cog"></i>
                <p>
                    Painel de Controle
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
            </a>
        </li>

        <li class="nav-item @if(request()->is('aluno/dados-pessoais')) active @endif">
            <a href="{{ route('sistema.alunos.dados') }}" class="nav-link">
                <i class="fas fa-user-lock"></i>
                <p>
                    Dados Pessoais
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
            </a>
        </li>
        <li class="nav-item has-treeview @if(request()->is('aluno/meu-plano/*')) menu-open @endif">
            <a href="#" class="nav-link">
                <i class="fas fa-comment-dollar"></i>
                <p>
                    Meu Plano
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item @if(request()->is('aluno/meu-plano/status')) active @endif">
                    <a href="{{ route('sistema.alunos.pagamentos') }}" class="nav-link">
                        <i class="fas fa-exclamation"></i>
                        <p>Status do Plano</p>
                    </a>
                </li>
                @if($usuario->pais == 1 )
                    <li class="nav-item @if(request()->is('aluno/meu-plano/alterar')) active @endif">
                        <a href="{{ route('sistema.alunos.plano.alterar') }}" class="nav-link">
                            <i class="fas fa-random"></i>
                            <p>Alterar Plano</p>
                        </a>
                    </li>
                    <li class="nav-item @if(request()->is('aluno/meu-plano/alterar-forma-pagamento')) active @endif">
                        <a href="{{ route('sistema.alunos.plano.alterar.pagamento') }}" class="nav-link">
                            <i class="fas fa-dollar-sign"></i>
                            <p>Alterar Forma Pagamento</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @if( $usuario->plano()->exists()  )
        <li class="nav-item has-treeview @if(request()->is('aluno/ead/*')) menu-open  @endif">
            <a href="#" class="nav-link">
                <i class="fas fa-chalkboard-teacher"></i>
                <p>
                    Aulas Gravadas
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item @if(request()->is('aluno/ead/cursos-gratis')) active @endif">
                    <a href="{{ route('sistema.alunos.cursos-gratis') }}" class="nav-link">
                        <i class="fas fa-coins"></i>
                        <p>
                            Cursos Grátis
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/ead/todos-os-cursos')) active @endif">
                    <a href="{{ route('sistema.alunos.todos-cursos') }}" class="nav-link">
                        <i class="fas fa-book-open"></i>
                        <p>Todos os Cursos</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/ead/meus-cursos') || request()->is('aluno/ead/curso/*')) active @endif">
                    <a href="{{ route('sistema.alunos.meus-cursos') }}" class="nav-link">
                        <i class="fas fa-music"></i>
                        <p>Meus Cursos</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/ead/materiais')) active @endif">
                    <a href="{{ route('sistema.alunos.materiais') }}" class="nav-link">
                        <i class="fas fa-archive"></i>
                        <p>Materiais</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/ead/preferidos')) active @endif">
                    <a href="{{ route('sistema.alunos.preferidos') }}" class="nav-link">
                        <i class="fas fa-star"></i>
                        <p>Preferidos</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/ead/certificados')) active @endif">
                    <a href="{{ route('sistema.alunos.vod.certificados') }}" class="nav-link">
                        <i class="fas fa-certificate"></i>
                        <p>Certificados</p>
                    </a>
                </li>
            </ul>
        </li>
    @endif
        <li class="nav-item has-treeview @if(request()->is('aluno/aovivo/*')) menu-open  @endif">
            <a href="#" class="nav-link">
                <i class="fas fa-laptop"></i>
                <p>
                    Aulas ao Vivo
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item @if(request()->is('aluno/aovivo/aulas')) active @endif">
                    <a href="{{ route('sistema.alunos.aovivo.aulas') }}" class="nav-link">
                    <i class="fas fa-calendar"></i>
                        <p>Minhas Aulas</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/aovivo/agendar/pagas')) active @endif">
                    <a href="{{ route('sistema.alunos.aovivo.agendar.pagas') }}" class="nav-link">
                    <i class="fas fa-file-invoice-dollar"></i>
                        <p>Agendar Aulas Pagas</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/aovivo/pagamentos')) active @endif">
                    <a href="{{ route('sistema.alunos.aovivo.pagamentos') }}" class="nav-link">
                        <i class="fas fa-dollar-sign"></i>
                        <p>Meus Pedidos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sistema.aluno.aovivo') }}" target="_blank" class="nav-link">
                        <i class="far fa-calendar-alt"></i>
                        <p>Comprar Novas Aulas</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('aluno/aovivo/avaliacoes')) active @endif">
                    <a href="{{ route('sistema.alunos.aovivo.avaliacoes') }}" class="nav-link">
                        <i class="fas fa-star"></i>
                        <p>
                            Avaliações
                            @if( $avCount > 0 )
                                <span class="badge badge-danger text-14-pt right">{{ $avCount }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('sistema.sair') }}" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                <p>
                    Sair
                </p>
            </a>
        </li>
    </ul>
</nav>