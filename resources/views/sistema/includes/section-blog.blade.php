<section class="section_blog">
    <div class="container">
        <div class="row justify-content-between align-items-center mb-5 mb-xl-4">
            <div class="col-12 col-xl-auto mb-3 mb-xl-0 text-center text-xl-left">
                <header class="section_blog_header">
                    <h2>Nosso blog</h2>
                    <p>Mantenha-se atualizado sobre o Universo da música</p>
                </header>
            </div>

            <div class="col-12 col-xl-auto text-center">
                <a class="section_blog_header_more" title="Acessar o blog" href="?file=blog">
                    Acessar o blog <i class="fas fa-paper-plane"></i>
                </a>
            </div>
        </div>

        <div class="section_blog_list">
            <div class="row">
                <?php for ($i = 0; $i <= 2; $i++): ?>
                    <div class="col-12 col-xl-4 my-4">
                        <article>
                            <a class="thumb" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"
                               href="?file=blog-post">
                                <img src="{{assets('sistema/images/post-thumbnail.png')}}"
                                     title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"
                                     alt="Lorem ipsum dolor sit amet, consectetur adipiscing elit">
                            </a>

                            <header>
                                <span>16/01/2020</span>
                                <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>
                                <a title="Categoria" href="?file=blog-category">Categoria</a>
                            </header>

                            <div class="more">
                                <a title="Leia mais" href="?file=blog-post">Leia mais</a>
                                <p><i class="far fa-clock"></i> 10 min leitura</p>
                            </div>
                        </article>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>