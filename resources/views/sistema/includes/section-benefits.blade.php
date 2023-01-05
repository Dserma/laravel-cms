<section class="section_benefits">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-xl-4 mb-5 mb-xl-0">
                <header class="section_benefits_header text-center text-xl-left">
                    <img src="{{assets('sistema/images/icons/guitar.png')}}" title="Vantages Guitarpedia"
                         alt="Vantages Guitarpedia">
                    <h2>Vantages <b>Guitarpedia</b></h2>
                    {!! $sobre->texto_vantagens !!}
                </header>
            </div>

            <div class="col-12 col-xl-8 pl-3 pl-xl-5">
                <div class="section_benefits_list">
                    <div class="row">
                        @foreach( json_decode($sobre->vantagens)->vantagens as $vantagem)
                            <div class="col-12 col-xl-6 my-3 my-xl-0">
                                <article class="text-center">
                                    <img class="mb-3" src="{{assets('sistema/images/icons/accept.png')}}" title="{{ $vantagem->titulo }}
                                        alt="{{ $vantagem->titulo }}>
                                    <h3>{{ $vantagem->titulo }}</h3>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>