@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

    <section class="view_blog">
        <header class="view_blog_header text-center text-xl-left">
            <div class="container">
                <nav class="mb-4" aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center justify-content-xl-start">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notícias</li>
                    </ol>
                </nav>

                <h1>Notícias</h1>
                <p>Mantenha-se atualizado</p>
            </div>
        </header>

        <div class="view_blog_content">
            <div class="container">
                <form action="" method="post">
                    <h2>Pesquise</h2>

                    <select name="category">
                        <option value="">Categorias</option>
                        <option value="Lorem Ipsum">Lorem Ipsum</option>
                        <option value="Como ser professor">Como ser professor</option>
                        <option value="Como ser aluno">Como ser aluno</option>
                        <option value="Formas de pagamento">Formas de pagamento</option>
                    </select>
                    <input type="text" name="search" placeholder="Ou digite a palavra-chave">
                    <button type="submit">Buscar</button>
                </form>

                <div class="view_blog_content_featured mb-5">
                    <div class="row">
                        <?php for ($i = 0; $i <= 1; $i++): ?>
                            <div class="col-12 col-xl-6 my-4">
                                <article>
                                    <a class="thumb" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"
                                    href="?file=blog-post">
                                        <img src="{{ assets('sistema/images/post-thumbnail.png') }}"
                                            title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"
                                            alt="Lorem ipsum dolor sit amet, consectetur adipiscing elit">
                                    </a>

                                    <header>
                                        <span>16/01/2020</span>
                                        <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
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

                <section class="view_blog_content_read">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-5 mb-xl-0">
                            <header class="view_blog_content_read_header">
                                <h2>Leia mais</h2>
                            </header>

                            <div class="view_blog_content_read_top">
                                <div class="row">
                                    <?php for ($i = 0; $i <= 1; $i++): ?>
                                        <div class="col-12 col-xl-6 my-4">
                                            <article class="text-center text-xl-left">
                                                <a class="thumb" href="?file=blog-post"
                                                title="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don">
                                                    <img src="{{ assets('sistema/images/post-thumbnail.png') }}"
                                                        title="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don"
                                                        alt="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don">
                                                </a>

                                                <header>
                                                    <h3>Lorem ipsum dolor sit amet, donus consectetur adipiscing elit
                                                        don</h3>
                                                    <p>Março de 2020</p>
                                                </header>

                                                <div class="description">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
                                                        ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                                                        accumsan lacus vel facilisis.
                                                    </p>
                                                </div>

                                                <a class="link"
                                                title="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don"
                                                href="?file=blog-post">Leia mais <i class="fas fa-chevron-right"></i></a>
                                            </article>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="view_blog_content_read_bottom">
                                <?php for ($i = 0; $i <= 1; $i++): ?>
                                    <article class="my-4">
                                        <a class="thumb mb-4 mb-xl-0" href="?file=blog-post"
                                        title="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don">
                                            <img src="{{ assets('sistema/images/post-thumbnail.png') }}"
                                                title="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don"
                                                alt="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don">
                                        </a>

                                        <div class="text">
                                            <header>
                                                <h3>Lorem ipsum dolor sit amet, donus  nsectetur adipiscing elit donus mega ipsum</h3>
                                                <p>Março de 2020</p>
                                            </header>

                                            <div class="description">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                    tempor incididunt ut labore et
                                                </p>
                                            </div>

                                            <a class="link"
                                            title="Lorem ipsum dolor sit amet, donus  consectetur adipiscing elit don"
                                            href="?file=blog-post">Leia mais <i class="fas fa-chevron-right"></i></a>
                                        </div>
                                    </article>
                                <?php endfor; ?>

                                <nav class="d-flex flex-wrap justify-content-center mt-5" aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item previus disabled">
                                            <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item active">
                                            <span class="page-link">3<span class="sr-only">(current)</span></span>
                                        </li>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">30</a></li>
                                        <li class="page-item next">
                                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4">
                            <section class="view_blog_content_read_categories mb-5">
                                <h3>Categorias <i class="fas fa-angle-down"></i></h3>

                                <div class="menu">
                                    <a title="Nova Categoria" href="?file=blog-category">
                                        <i class="fas fa-chevron-right"></i> Nova Categoria
                                    </a>
                                    <a title="Nova Categoria" href="?file=blog-category">
                                        <i class="fas fa-chevron-right"></i> Nova Categoria
                                    </a>
                                    <a title="Nova Categoria" href="?file=blog-category">
                                        <i class="fas fa-chevron-right"></i> Nova Categoria
                                    </a>
                                    <a title="Nova Categoria" href="?file=blog-category">
                                        <i class="fas fa-chevron-right"></i> Nova Categoria
                                    </a>
                                    <a title="Nova Categoria" href="?file=blog-category">
                                        <i class="fas fa-chevron-right"></i> Nova Categoria
                                    </a>
                                </div>
                            </section>

                            <section class="view_blog_content_read_most">
                                <header class="view_blog_content_read_most_header">
                                    <h3>Mais lidos</h3>
                                </header>

                                <?php for ($i = 0; $i <= 3; $i++): ?>
                                    <article>
                                        <h4>
                                            <a href="?file=blog-post"
                                            title=" Lorem ipsum dolor sit amet, don consectetur adipiscing elit">
                                                Lorem ipsum dolor sit amet, don consectetur adipiscing elit
                                            </a>
                                        </h4>
                                        <p>Março de 2020</p>
                                    </article>
                                <?php endfor; ?>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop