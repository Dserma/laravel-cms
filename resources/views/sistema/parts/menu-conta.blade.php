<div class="row horizontal-center padding-top-20">
  <h2 class="mont text-green text-24-pt regular">Minha Conta</h2>
</div>
<div class="row divisor margin-top-20"></div>
<div class="row padding-20">
  <ul class="menu mont text-green text-18-pt semibold w-100">
    <li class="{{ Request::is('sua-conta') ? 'active' : '' }}"><a href="{{ route('sistema.sua-conta.index') }}">Meus Dados</a></li>
    @if( $usuario->status_pedido == 1 )
      <li class="{{ Request::is('sua-conta/meus-produtos*') ? 'active' : '' }}"><a href="{{ route('sistema.sua-conta.produtos') }}">Meus Produtos</a></li>
    @endif
    <li class="{{ Request::is('sua-conta/meu-plano*') ? 'active' : '' }}"><a href="{{ route('sistema.sua-conta.plano') }}">Meu Plano</a></li>
  </ul>
</div>