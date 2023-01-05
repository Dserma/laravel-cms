<section class="section_teachers">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-5 mb-5 mb-xl-0">
                <header class="section_teachers_header">
                    <img src="{{assets('sistema/images/icons/guitar.png')}}"
                         title="Veja alguns professores" alt="Veja alguns professores">
                    {!! $home->titulo_professores !!}
                    {!! $home->subtitulo_professores !!}
                    {!! $home->texto_professores !!}
                    <div class="more">
                        <a title="Ver todos os professores" href="{{ route('sistema.professores.index') }}">Ver todos os professores</a>
                    </div>
                </header>
            </div>

            <div class="col-12 col-xl-7">
                <div class="section_teachers_list">
                    <div class="slick-teachers">
                        @foreach($professores as $professor)
                            <div class="px-3">
                                <article>
                                    <a class="photo" href="{{ route('sistema.professor.index', [$professor->categoria->slug, $professor->slug]) }}">
                                        <img src="{{ $professor->imagem }}" title="{{ $professor->nome }}" alt="{{ $professor->nome }}">
                                        <span class="line"></span>
                                    </a>

                                    <header>
                                        <h3>{{ $professor->nome }}</h3>
                                        <p>Professor de {{ $professor->categoria->nome }}</p>
                                    </header>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>