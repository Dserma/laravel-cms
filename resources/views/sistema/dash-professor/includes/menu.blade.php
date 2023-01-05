<aside class="main-sidebar sidebar-dark-primary">
  <a href="{{ route('sistema.index') }}" class="brand-link text-center">
      <img src="{{ assets('sistema/dash-professor/img/guitarpedia-logo.png') }}" alt="Guitarpedia" class="img-fluid">
  </a>

  <div class="sidebar">
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item @if(request()->is('dash-professor')) active @endif">
                  <a href="{{ route('sistema.dash-professor.index') }}" class="nav-link">
                      <i class="fas fa-user-cog nav-icon"></i>
                      <p>
                          Painel de Controle
                      </p>
                  </a>
              </li>
              <li class="nav-item @if(request()->is('dash-professor/meus-dados')) active @endif">
                  <a href="{{ route('sistema.dash-professor.dados') }}" class="nav-link">
                      <i class="fas fa-user-lock nav-icon"></i>
                      <p class="vertical-middle">
                          Dados Pessoais
                            @if( $usuario->cpf != null )
                                <i class="fas fa-check text-white right" title="Dados OK"></i>
                            @else
                                <i class="fas fa-ban right text-red" title="Dados incompletos"></i>
                            @endif
                      </p>
                  </a>
              </li>
              <li class="nav-item @if(request()->is('dash-professor/informacoes-financeiras')) active @endif">
                  <a href="{{ route('sistema.dash-professor.financeiro') }}" class="nav-link">
                      <i class="fas fa-hand-holding-usd nav-icon"></i>
                      <p>
                          Informações Financeiras
                            @if( $usuario->banco != null )
                                <i class="fas fa-check text-white right" title="Dados OK"></i>
                            @else
                                <i class="fas fa-ban right text-red" title="Dados incompletos"></i>
                            @endif
                      </p>
                  </a>
              </li>
              <li class="nav-item @if(request()->is('dash-professor/disponibilidade')) active @endif">
                  <a href="{{ route('sistema.dash-disponibilidade') }}" class="nav-link">
                      <i class="fas fa-user-check nav-icon"></i>
                      <p>
                          Disponibilidade
                          @if( $usuario->disponibilidades()->exists() )
                                <i class="fas fa-check text-white right" title="Dados OK"></i>
                            @else
                                <i class="fas fa-ban right text-red" title="Dados incompletos"></i>
                            @endif
                      </p>
                  </a>
              </li>
              <li class="nav-item @if(request()->is('dash-professor/minha-agenda')) active @endif">
                  <a href="{{ route('sistema.dash-professor.agenda') }}" class="nav-link">
                      <i class="fas fa-calendar-alt nav-icon"></i>
                      <p>
                          Minha Agenda de Aulas
                      </p>
                  </a>
              </li>
              <li class="nav-item @if(request()->is('dash-professor/aulas')) active @endif">
                  <a href="{{ route('sistema.dash-professor.aulas') }}" class="nav-link">
                      <i class="fas fa-video nav-icon"></i>
                      <p>
                          Crie uma Aula
                          @if( $usuario->aulas()->exists() )
                                <i class="fas fa-check text-white right" title="Dados OK"></i>
                            @else
                                <i class="fas fa-ban right text-red" title="Dados incompletos"></i>
                            @endif
                      </p>
                  </a>
              </li>
              <li class="nav-item @if(request()->is('dash-professor/pacotes')) active @endif">
                  <a href="{{ route('sistema.dash-professor.pacotes') }}" class="nav-link">
                      <i class="fas fa-briefcase nav-icon"></i>
                      <p>
                          Pacote de Aulas
                      </p>
                  </a>
              </li>
              <li class="nav-item @if(request()->is('dash-professor/cupons')) active @endif">
                  <a href="{{ route('sistema.dash-professor.cupons') }}" class="nav-link">
                      <i class="fas fa-tags nav-icon"></i>
                      <p>
                          Cupons de Desconto
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('sistema.dash-professor.avaliacoes') }}" class="nav-link">
                      <i class="fas fa-star nav-icon"></i>
                      <p>
                            Avaliações
                            @if( $avCount > 0 )
                                <span class="badge badge-danger text-14-pt right">{{ $avCount }}</span>
                            @endif
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('sistema.sair') }}" class="nav-link">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                      <p>
                          Sair
                      </p>
                  </a>
              </li>
          </ul>
      </nav>
  </div>

</aside>