<div class="modal_cart">
    <div class="modal_cart_content relative">
        <div class="modal_cart_header">
            <p class="xs-padding-bottom-10"><i class="fas fa-shopping-cart"></i> Carrinho</p>
            @if(!request()->is('aovivo/pagar'))
                <a title="Fechar" class="close" data-close=".modal_cart">Continuar Comprando</a>
            @else
                <a href="{{ route('sistema.aluno.aovivo') }}" title="Continuar" class="close">Adicionar mais aulas</a>
            @endif
        </div>
        <div class="modal_cart_body flex-column relative">
            @if($cart < 1 )
                <div class="row">
                    <p class="modal_cart_body_title">Continue agendando mais aulas</p>
                </div>
            @endif
            <div class="row produtos">
                
            </div>
            @if(request()->is('aovivo/pagar'))
                <div class="row flex-column margin-top-30 margin-bottom-30">
                    <form  data-action="{{ route('sistema.alunos.aovivo.cupom') }}" class="flex-column form-normal">
                        <div class="row modal_cart_body_code vertical-middle">
                            <div class="col-lg-8 text-right">
                                <p>Código promocional</p>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" name="cupom" class="form-control" placeholder="Digite aqui...">
                            </div>
                        </div>
                        <div class="row margin-top-20 horizontal-right padding-right-20">
                            <button class="modal_cart_body_send" type="submit">Validar Código</button>
                        </div>
                    </form>
                </div>
            @endif
            <div class="row horizontal-right">
                <div class="modal_cart_body_resume">
                    <p><span>Subtotal</span><span class="valor-original"></span></p> 
                    <p><span>Total de Descontos</span>  <span class="descontos text-red"> </span></p> 
                    <p class="total"><span>Total do pedido</span>  <span class="valor-total"></span></p>
                </div>
            </div>
            @if(!request()->is('aovivo/pagar'))
                <div class="row horizontal-right cart-pagar @if($cart < 1 || request()->is('aovivo/pagar')) d-none @endif">
                    <a href="{{ route('sistema.aovivo.pagar') }}" class="modal_cart_body_send">Realizar Pagamento</a>
                </div>
            @endif
            @if(request()->is('aovivo/pagar'))
                <div class="row horizontal-center">
                    <p class="title text-20-pt semibold">Formas de pagamento</p>
                </div>
                <div class="row">
                    <ul class="nav nav-tabs justify-content-center" id="paymentTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="credit-tab" data-toggle="tab" href="#credit" role="tab" aria-controls="credit" aria-selected="true">Cartão de Crédito</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="bullet-tab" data-toggle="tab" href="#bullet" role="tab" aria-controls="bullet" aria-selected="false">Boleto Bancário</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="paymentTabContent">
                    <div class="tab-pane fade show active padding-bottom-50" id="credit" role="tabpanel" aria-labelledby="credit-tab">
                        <div class="text-center mb-5">
                            <img src="{{ assets('sistema/images/icons/flags-card.png') }}" alt="Bandeiras de Cartão de Crédito">
                        </div>
                        <form data-action="{{ route('sistema.alunos.aovivo.pagar.cartao') }}" class="form-normal margin-top-30 col-lg-8 center-block">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCardNumber">Número do cartão</label>
                                    <input type="text" name="cartao" class="form-control credit-input-mask" id="inputCardNumber" placeholder="Digite aqui...">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputCardHold">Nome impresso no cartão</label>
                                    <input type="text" name="titular" class="form-control" id="inputCardHold" placeholder="Digite aqui...">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputCardValidate">Validade</label>
                                    <input type="text" name="validade" class="form-control validade-input-mask-2" id="inputCardValidate" placeholder="mm/aa">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputCardCVV">CVV</label>
                                    <input type="text" name="cvv" class="form-control cvv-input-mask" id="inputCardCVV" maxlength="4">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputCPF">CPF</label>
                                    <input type="text" name="cpf" value="{{ $usuario->cpf }}" class="form-control cpf-input-mask" id="inputCPF">
                                </div>
                            </div>
                            <div class="row horizontal-right">
                                <button type="submit" class="modal_cart_body_send">Pagar agora!</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade padding-bottom-50" id="bullet" role="tabpanel" aria-labelledby="bullet-tab">
                        <div class="row margin-top-20 horizontal-center">
                            <img src="{{ assets('sistema/images/boleto.png') }}" alt="">
                        </div>
                        <form data-action="{{ route('sistema.alunos.aovivo.pagar.boleto') }}" class="form-normal cadastro col-lg-8 center-block">
                            <div class="row margin-top-20 margin-bottom-20 horizontal-center">
                                <div class="col-lg-6">
                                    <label for="">CPF para o boleto</label>
                                    <input type="text" name="cpf" class="form-control cpf cpf-input-mask">
                                </div>
                            </div>
                            <div class="row horizontal-center">
                                <button type="submit" class="modal_cart_body_send">Gerar Boleto </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>