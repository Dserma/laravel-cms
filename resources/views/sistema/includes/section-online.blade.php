<section class="section_online">
    <div class="container">
        <header class="section_online_header text-center mb-4">
            <img src="{{assets('sistema/images/icons/classes-online.png')}}" title="+ de 400 aulas online!" alt="+ de 400 aulas online!">
            <h2><b>AGENDE SUA AULA AO VIVO!</b></h2>
            <p>Escolha o professor, o <b>dia e horário e agende a sua aula</b></p>
        </header>

        <div class="section_online_list">
            <div class="slick-courses-live">
                @foreach( $professoresA as $p )
                    <div class="px-2">
                        <article class="text-center">
                            <a class="thumb" href="{{ route('sistema.aluno.aovivo.professor', $p->slug) }}">
                                <img src="{{ $p->imagem }}" title="{{ $p->fullName }}"
                                     alt="{{ $p->fullName }}">
                            </a>
                            <header>
                                @foreach($p->categorias->take(3) as $c )
                                    <a href="#">{{ $c->nome }}</a>
                                @endforeach
                                <h3>{{ $p->fullName }}</h3>
                            </header>

                            <div class="details">
                                <p><i class="fas fa-dollar-sign"></i> {{ $p->aulas->sortBy('valor')->first() ? currencyToApp($p->aulas->sortBy('valor')->first()->valor) : null }}</p>
                                <p><i class="fas fa-stopwatch"></i> {{ $p->aulas->sortBy('valor')->first() ? $p->aulas->sortBy('valor')->first()->duracao . 'minutos' : null }}</p>
                            </div>
                            <a class="schedule" href="{{ route('sistema.aluno.aovivo.professor', $p->slug) }}">Agendar aula</a>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row horizontal-center section_online_list margin-top-100">
        <article>
            <a class="schedule" href="{{ route('sistema.aluno.aovivo') }}">Encontre mais professores</a>
        </article>
    </div>
</section>