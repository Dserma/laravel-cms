<div class="modal_cart_body_product cart-item">
  <div class="modal_cart_body_product_content">
      <div class="row justify-content-between xs-padding-10">
          <div class="col-12 col-xl-9">
              <div class="row justify-content-between align-items-center">
                  <div class="thumb col-xl-2" style="background-image: url('{{ $c->professor->imagem }}')"></div>
                  <div class="text col-xl-10">
                      <p><b class="text-red">{{ $c->duracao }} minutos</b> de Aula de <b class="text-red">{{ $c->categoria->nome }}</b> com {{ $c->professor->present()->fullName() }}</p>
                      <ul class="radio vertical-middle">
                          <li>
                            <input type="radio" name="tipo_{{ $c->id }}" id="tipo_{{ $c->id }}_1" value="a_{{ $c->id }}" @if($c->pacote == '') checked @endif>
                            <label for="tipo_{{ $c->id }}_1" class="tipo-aula" data-url="{{ route('sistema.aovivo.agendaaula', $c->professor->id) }}" data-type="a" data-obj="{{ $c->id }}">{{ $c->quantidade }} aula(s)</label>
                          </li>
                          @forelse($c->pacotes as $p)
                            <li>
                              <input type="radio" name="tipo_{{ $c->id }}" id="tipo_{{ $c->id }}_{{ $p->id }}" value="{{ $p->id }}" @if($c->pacote == $p->id) checked @endif>
                              <label for="tipo_{{ $c->id }}_{{ $p->id }}" class="tipo-aula" data-url="{{ route('sistema.aovivo.agendaaula', $p->professor->id) }}" data-type="p" data-obj="{{ $p->id }}">{{ $p->quantidade }} aulas<span>({{ $p->desconto }}% off)</span></label>
                            </li>
                          @empty
                          @endforelse
                      </ul>
                  </div>
              </div>
          </div>
          <div class="col-12 col-xl-3">
              <div class="price text-right">
                @if($c->pacote != '')
                  <span>{{ currencyToAppDot($c->present()->getValorPacote()) }}</span>
                  <p class="somar" data-original="{{ currencyToAppDot($c->present()->getValorPacote()) }}" data-valor="{{ currencyToAppDot($c->total * $c->quantidade) }}">{{ currencyToApp($c->total * $c->quantidade) }}</p>
                @else
                  @if(session()->has('cupom') && array_key_exists($c->id, session('cupom')) )
                    <span>{{ currencyToApp($c->valor * $c->quantidade) }}</span>
                  @endif
                  <p class="somar" data-original="{{ currencyToAppDot($c->valor * $c->quantidade) }}" data-valor="{{ currencyToAppDot($c->total * $c->quantidade) }}">{{ currencyToApp($c->total * $c->quantidade) }}</p>
                  <div class="form-group mb-0 quantidade">
                    <div class="row horizontal-right">
                        <div class="col-6">
                            <label for="">Quantidade:</label>
                            <input type="number" name="qtd" min="1"  class="form-control qtd qtd_{{ $c->id }}" value="{{ $c->quantidade }}">
                        </div>
                    </div>
                    <div class="row horizontal-right margin-top-20 padding-right-30">
                        <button class="btn btn-danger btn-sm btn-quantidade" type="button" data-url="{{ route('sistema.aovivo.agendaaula', $c->professor->id) }}" data-type="a" data-obj="{{ $c->id }}">Atualizar</button>
                    </div>
                </div>
                @endif
              </div>
          </div>
      </div>
  </div>

  <div class="modal_cart_body_product_bottom">
      <button class="removed remover-cart" data-texto="Confirma a remoção desta aula do seu carrinho?" data-url="{{ route('sistema.aovivo.cart.remover', $c->id) }}"><i class="fas fa-trash"></i> Remover</button>
  </div>
</div>