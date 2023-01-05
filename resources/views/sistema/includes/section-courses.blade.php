<section class="section_courses" id="cursos-home">
    <div class="container">
        <header class="section_courses_header text-center mb-5">
            <img src="{{assets('sistema/images/icons/guitar-light.png')}}" title="+ de 400 aulas online!"
                 alt="+ de 400 aulas online!">
            <h2>{!! $home->titulo_cursos !!}</h2>
            <p>{!! $home->subtitulo_cursos !!}</p>
        </header>

        <div class="section_courses_content">
            <div class="row">
                <div class="col-12 col-xl-3 mb-5 mb-xl-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach( $categorias as $categoria )
                            <a class="nav-link @if($loop->first) active @endif" id="{{ $categoria->slug }}-tab" data-toggle="tab" data-go=".tab-content" href="#{{ $categoria->slug }}" role="tab" aria-controls="{{ $categoria->slug }}" aria-selected="true">
                                {{ $categoria->nome }} <i class="fas fa-chevron-right"></i>
                            </a>
                        @endforeach
                    </div>

                    <div class="section_courses_teachers">
                        <img src="{{assets('sistema/images/icons/people.png')}}" title="{!! $home->box_professores_cursos !!}"
                             alt="{!! $home->box_professores_cursos !!}">
                        {!! $home->box_professores_cursos !!}
                        <a title="Conheça os professores" href="{{ route('sistema.professores.index') }}">conheça</a>
                    </div>
                </div>

                <div class="col-12 col-xl-9">
                    <div class="tab-content section_courses-contents" id="v-pills-tabContent">
                        @foreach( $categorias as $categoria )
                            <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $categoria->slug }}" role="tabpanel" aria-labelledby="{{ $categoria->slug }}-tab">
                                <div class="slick-courses row">
                                    @forelse( $categoria->cursosPagos->sortBy('order') as $curso )
                                        <div class="col-lg-4 px-2 mb-4 curso">
                                            <article class="text-center text-xl-left">
                                                <a class="thumb" title="{{ $curso->titulo }}" href="{{ route('sistema.vod.curso', [$categoria->slug, $curso->slug]) }}">
                                                    <img src="{{ $curso->imagem }}"
                                                        title="{{ $curso->titulo }}" alt="{{ $curso->titulo }}">
                                                    <span>{{ $curso->professor->nome }}</span>
                                                </a>
                                                <header>
                                                    <h3>{{ $curso->titulo }}</h3>
                                                </header>
                                                <div class="details">
                                                    <p><i class="fas fa-book"></i> {{ $curso->present()->countAulas() }} aulas</p>
                                                    {{-- <p>{{ $curso->present()->countBts() }}  BTs</p> --}}
                                                </div>
                                            </article>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <a class="load_more" title="Carregar mais" href="{{ route('sistema.vod.index', $categoria->slug) }}">Ver Todos</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-12">
                    <div class="section_courses_content_cta mt-5">
                        <p>Conheça todos os nossos cursos</p>
                        <a href="{{ route('sistema.vod.index') }}">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>