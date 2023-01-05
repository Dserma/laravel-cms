<section class="section_testemonials">
    <div class="container">
        <header class="section_testemonials_header text-center">
            {!! $home->titulo_depoimentos !!}
            <h2>Veja o que os nossos clientes têm a dizer!</h2>
        </header>

        <div class="section_testemonials_list">
            <div class="slick-testemonials">
               @foreach($depoimentos as $depoimento)
                    <div class="px-3">
                        <article class="text-center">
                            <div class="thumb">
                                <img src="{{ $depoimento->imagem }}" title="{{ $depoimento->nome }}"
                                     alt="{{ $depoimento->nome }}">
                            </div>

                            <header>
                                <h3>{{ $depoimento->nome }}</h3>
                                {!! $depoimento->conteudo !!}
                            </header>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
</section>