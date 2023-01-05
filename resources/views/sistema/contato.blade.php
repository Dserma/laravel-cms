@extends('sistema.layouts.default')
@section('content')
<!--MAIN HEADER-->
@include("sistema/includes/main-header")
<!--MAIN HEADER-->

<section class="view_contact">
    <header class="view_contact_header text-center text-xl-left">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center justify-content-xl-start">
                    <li class="breadcrumb-item"><a href="{{ route('sistema.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fale conosco</li>
                </ol>
            </nav>

            <h1>Fale conosco</h1>
            <p>Tem alguma dúvida? Envie para o nosso time!</p>
        </div>
    </header>

    <div class="view_contact_content">
        <div class="container">
            <div class="view_contact_content_more">
                <div class="view_contact_content_more_header">
                    <h2>Informações de contato</h2>
                    <p>Preencha o formulário ou ligue para nós</p>
                </div>

                <div class="view_contact_content_more_info">
                    <div class="view_contact_content_more_info_item">
                        <div class="icon"><i class="fas fa-phone"></i></div>
                        <div class="text">
                            <p>Atendimento</p>
                            <a href="https://api.whatsapp.com/send?1=pt_BR&phone=55{{ preg_replace('/[^0-9]/', '', $configs->whatsapp)}}" target="_blank">{{ $configs->whatsapp }}</a>
                        </div>
                    </div>
                    <div class="view_contact_content_more_info_item">
                        <div class="icon"><i class="fas fa-envelope"></i></div>
                        <div class="text">
                            <p>Envie-nos um e-mail</p>
                            <p>{{ $configs->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <form data-action="{{ route('sistema.contato.envia') }}" class="form-normal">
                <h2>Formulário de contato</h2>

                <div class="form-group">
                    <label for="inputName">Nome</label>
                    <input type="text" name="nome" class="form-control" id="inputName" placeholder="Digite aqui..."
                           required>
                </div>

                <div class="form-group">
                    <label for="inputEmail">E-mail</label>
                    <input type="email" class="form-control" id="inputEmail" placeholder="Digite aqui..." name="email" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputPhone">Telefone</label>
                        <input type="text" name="telefone" class="form-control telefone-input-mask" id="inputPhone"
                               placeholder="Digite aqui..." required>
                    </div>

                    <div class="form-group col-md-9">
                        <label for="inputSubject">Assunto</label>
                        <input type="text" name="assunto" class="form-control" id="inputSubject"
                               placeholder="Digite aqui..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="textareaMessage">Mensagem</label>
                    <textarea name="mensagem" class="form-control" id="textareaMessage" rows="3"
                              placeholder="Digite aqui..." required></textarea>
                </div>

                <button type="submit">Pronto, enviar mensagem</button>
            </form>
        </div>
    </div>
</section>

<!--SECTION CTA-->
@include("sistema/includes/section-cta")
<!--SECTION CTA-->
@stop
@section('scripts')
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>        
@stop