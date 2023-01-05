<div class="row padding-top-25 padding-bottom-25 item preferido">
    <div class="col-lg-1">
        <div class="row imagem">
            <img src="{{ $curso->imagem }}" alt="">
        </div>
    </div>
    <div class="col-lg-11 padding-left-15 quick text-gray">
        <div class="row text-24-pt semibold">
            {{ $curso->titulo }}
        </div>
        <div class="row margin-top-10 text-14-pt regular">
            {{ $curso->nivel->nome }}
        </div>
        <div class="row margin-top-10 text-14-pt regular vertical-middle">
            <i class="fas fa-chalkboard-teacher padding-right-5"></i>
            Professor: {{ $curso->professor->nome }}
        </div>
        <div class="row margin-top-20 text-14-pt regular vertical-middle">
            <a href="{{ route('sistema.alunos.vod.curso.player', [$curso->slug, $curso->present()->continuar($usuario)['modulo'], $curso->present()->continuar($usuario)['aula']]) }}">
                <i class="fas fa-play-circle padding-right-5"></i>
                Assistir
            </a>
        </div>
        <div class="row margin-top-20 text-14-pt regular vertical-middle">
            <a href="#r" data-url="{{ route('sistema.alunos.vod.preferido.remover', $curso->slug) }}" data-texto="Confirma a exclusão deste curso de seus preferidos?" class="remover submit-single-post">
                <i class="fas fa-minus-circle padding-right-5"></i>
                Remover dos Preferidos
            </a>
        </div>
    </div>
</div>