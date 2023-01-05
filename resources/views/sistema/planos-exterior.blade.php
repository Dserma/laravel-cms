@extends('sistema.layouts.vazio')
@section('content')

<section class="view_contact">
    <div class="view_contact_content">
        <div class="container">
            <div class="row text-black text-16-pt semibold text-center">
                Para outros países, devido a restrições de pagamentos, temos apenas estes planos de assinaturas disponíveis. <br><br>
                Por favor, selecione um dos planos abaixo:
            </div>
            <div class="view_cart_content_packages">
                <div class="row horizontal-center">
                    @foreach( $planos->where('plano_id_paypal', '!=', null) as $plano )
                        <div class="col-12 col-md-6 col-xl-3 my-4">
                            <article>
                                <header>
                                    <span class="headline">{{ $plano->nome }}</span>
                                    {{-- <h3>Mensal</h3> --}}
                                    <p>{{ $plano->descricao }}</p>
                                </header>

                                <div class="details">
                                    <p>{{ currencyToApp($plano->valor) }}</p>

                                    <input type="radio" name="package" class="radio-plano-internacional" id="plano_{{ $plano->id }}" value="{{ $plano->slug }}" data-paypal="{{ $plano->plano_id_paypal == null ? 'null' : $plano->plano_id_paypal }}" data-id="{{ $plano->id }}" data-gratuito="{{ $plano->gratuito }}" data-step="#register" data-descricao="{{ $plano->descricao }}" data-titulo="{{ $plano->nome }}" data-valor="{{ currencyToApp($plano->valor) }}">
                                    <label for="plano_{{ $plano->id }}">Quero este</label>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@stop