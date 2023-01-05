@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->
<section class="view_terms">
    <header class="view_terms_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Confirmação de Assinatura</li>
                </ol>
            </nav>

            <h1>Confirmação de Assinatura</h1>
            <p>Obrigado!</p>
        </div>
    </header>

    <div class="view_terms_content">
        <div class="container padding-bottom-100">
            <div class="htmlchars">
               {!! $conteudo->conteudo !!}
            </div>
        </div>
    </div>
    @if($request->session()->has('urlBoleto') )
        <a data-modal=".modal_boleto" href="javascript: void(0)" class="boleto text-white padding-right-20">
        </a>
        @include("sistema.includes.modal-boleto")
        @php $request->session()->forget('urlBoleto'); @endphp
    @endif
</section>

<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop

@section('scripts')
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script> 
    <script>
        //fbq('track', 'Purchase', {value: '{{ $usuario->plano->valor }}', currency: 'BRL'});
        fbq('track', 'Subscribe', {value: '{{ $usuario->plano->valor }}', currency: 'BRL', predicted_ltv: '{{ $usuario->plano->valor }}'});
        $(document).ready(function(){
            $('a.boleto').click();
        })
        function readCookie(name) {
            return (name = new RegExp('(?:^|;\\s*)' + ('' + name).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&') + '=([^;]*)').exec(document.cookie)) && name[1];
        }
    </script>
    <!-- "Thank you page" only-->
    <script>
        // unique transaction id
        let TXN_ID = '{{ $usuario->assinatura_gateway_id }}';
        // publisher commission
        let SALE_AMOUNT = '{{ $usuario->plano->valor }}';
        // order currency
        let CURRENCY = "BRL";
        // offer (campaign) id
        let OFFER_ID = 11170;
        // network domain
        let NETWORK =  "https://trk.indoleads.com";
    </script>
    <script src="https://static.indoleads.com/js/platform/pixel.js"></script>
    <!-- / "Thank you page" only-->
@stop

@section('lomade')
    <script>
        dataLayer = [{
            aulasgravadas:{
                compra: {
                    actionField:{
                        id:  '{{ $usuario->assinatura_gateway_id }}',
                        affiliation: '',
                        revenue: '{{ currencyToAppDot($usuario->plano->valor) }}',
                        tax: '{{ $cupom ? currencyToAppDot( ($usuario->plano->valor / 100) * $cupom->percentual ) : 0 }}',
                        shipping:  '',
                        coupon: ''
                    },
                    products: [
                        {
                            id: '{{ $usuario->plano->id }}',
                            name: '{{ $usuario->plano->slug }}',
                            price: '{{ currencyToAppDot($usuario->plano->valor) }}',
                            sku: '0{{ $usuario->plano->id }}',
                            quantity: '1',
                            category: 'aulasgravadas'
                        }
                    ]
                }
            }
        }];
    </script>
@stop