<section class="section_about xs-text-center">
    <span class="guitar">guitar</span>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-xl-6 mb-4 mb-xl-0">
                <header class="section_about_header">
                    <img src="{{assets('sistema/images/icons/guitar.png')}}"
                         title="Vem conosco, vamos aprender música" alt="Vem conosco, vamos aprender música">

                    <div class="text">
                        {!! $sobre->conheca !!}
                    </div>
                </header>
            </div>

            <div class="col-12 col-xl-6">
                <div class="section_about_description">
                    {!! $sobre->resumo_historia !!}
                </div>
                @if(!request()->is('quem-somos'))
                    <a class="section_about_more" title="Conheça nossa história" href="{{ route('sistema.quem-somos') }}">
                        Conheça nossa história <i class="fas fa-long-arrow-alt-right"></i>
                    </a>
                @else
                    <a class="section_about_more" title="Conheça nossa história" href="{{ route('sistema.historia') }}">
                        Conheça nossa história <i class="fas fa-long-arrow-alt-right"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <span class="pedia">pedia</span>
</section>