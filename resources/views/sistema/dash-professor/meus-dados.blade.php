@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_profile">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-user-lock"></i> Dados Pessoais</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT HEADER -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form class="form-normal" data-action="{{ route('sistema.dash-professor.dados.salvar') }}">
                        <input type="hidden" name="id" value="{{ $usuario->id }}">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Informações Básicas</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="inputFistName">
                                            <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                Nome*
                                            </div>
                                        </label>
                                        <input type="text" name="nome" value="{{ $usuario->nome }}" id="inputFistName" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="inputLastName">
                                            <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                Sobrenome*
                                            </div>
                                        </label>
                                        <input type="text" name="sobrenome" id="inputLastName" class="form-control" value="{{ $usuario->sobrenome }}" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="inputFistName">
                                            <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                CPF*
                                            </div>
                                        </label>
                                        <input type="text" name="cpf" value="{{ $usuario->cpf }}" id="cpf" class="form-control cpf-input-mask">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="inputLastName">
                                            <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                Data de Nascimento*
                                            </div>
                                        </label>
                                        <div class="input-group date" id="dateStart" data-target-input="nearest">
                                            <input type="text" name="nascimento" id="nascimento" value="{{ dateBdToApp($usuario->nascimento) }}" class="form-control datetimepicker-input data-input-mask" data-target="#dateStart"/>
                                            <div class="input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="inputPhone">Telefone</label>
                                        <input type="text" name="telefone" id="inputPhone" class="form-control telefone-input-mask" value="{{ $usuario->telefone }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="inputWhatsApp">WhatsApp</label>
                                        <input type="text" name="whatsapp" id="inputWhatsApp" class="form-control telefone-input-mask" value="{{ $usuario->whatsapp }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="inputEmail">
                                            <div class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                 title="Preenchimento Obrigatório">
                                                E-mail*
                                            </div>
                                        </label>
                                        <input readonly type="email" name="email" id="inputEmail" class="form-control" value="{{ $usuario->email }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="inputIdioms">Idiomas</label>
                                        @php $idiomas = json_decode($usuario->idiomas) @endphp
                                        <div class="form-check">
                                            <input class="form-check-input" id="idioma-1" type="checkbox" name="idiomas[]" value="1" @if (is_array($idiomas) && in_array(1, $idiomas)) checked @endif>
                                            <label class="form-check-label" for="idioma-1">Português</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="idioma-2" type="checkbox" name="idiomas[]" value="2" @if (is_array($idiomas) && in_array(2, $idiomas)) checked @endif>
                                            <label class="form-check-label" for="idioma-2">Inglês</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="idioma-3" type="checkbox" name="idiomas[]" value="3" @if (is_array($idiomas) && in_array(3, $idiomas)) checked @endif>
                                            <label class="form-check-label" for="idioma-3">Espanhol</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="inputCategoriesClasses">
                                            <div class="d-inline-block" tabindex="0">
                                                Categorias de Aulas* - <a href="#" data-toggle="modal" data-target="#modal-sm" class="text-red text-10-pt bold">Não encontrou sua categoria? Clique aqui e fale conosco.</a>
                                            </div>
                                        </label>
                                        {!! Form::select('categorias[]', $categorias, $usuario->categorias->pluck('id')->toArray(), ['class' => 'select2 form-control', 'multiple' => 'multiple']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="inputTimeZone">
                                            <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                Time Zone*
                                            </div>
                                        </label>
                                        @if( null !== $usuario->timezone )
                                            {!! Form::select('timezone', [null => 'Selecione'] + $zonas, $usuario->timezone, ['class' => 'select2']) !!}
                                        @else
                                            {!! Form::select('timezone', [null => 'Selecione'] + $zonas, 78, ['class' => 'select2']) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="endereco">
                                    <div class="row align-items-end">
                                        <div class="form-group col-sm-2">
                                            <label for="inputZipcode">
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                    CEP*
                                                </div>
                                            </label>
                                            <input type="text" name="cep" id="inputZipcode" class="form-control cep cep-input-mask"  value="{{ $usuario->cep }}">
                                        </div>
                                        <div class="form-group col-sm-10">
                                            <label for="inputStreet">
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                    Logradouro*
                                                </div>
                                            </label>
                                            <input type="text" name="logradouro" id="inputStreet" class="form-control logradouro"  value="{{ $usuario->logradouro }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label for="inputNumber">
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                    Número*
                                                </div>
                                            </label>
                                            <input type="text" name="numero" id="inputNumber" class="form-control numero"  value="{{ $usuario->numero }}">
                                        </div>
                                        <div class="form-group col-sm-9">
                                            <label for="inputComplement">Complemento</label>
                                            <input type="text" name="complemento" id="inputComplement" class="form-control"  value="{{ $usuario->complemento }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="inputNeighborhood">
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                    Bairro*
                                                </div>
                                            </label>
                                            <input type="text" name="bairro" id="inputNeighborhood" class="form-control bairro"  value="{{ $usuario->bairro }}">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="inputCity">
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                    title="Preenchimento Obrigatório">
                                                    Cidade*
                                                </div>
                                            </label>
                                            {!! Form::select('city_id', [null => ''] + $cidades, $usuario->present()->cidade($usuario->city_id), ['class' => 'localidade select2 form-control']) !!}
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="inputUF">
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                    title="Preenchimento Obrigatório">
                                                    UF*
                                                </div>
                                            </label>
                                            {!! Form::select('state_id', [null => ''] + $estados, $usuario->present()->estado($usuario->state_id), ['class' => 'uf select2 form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Dados Pessoais</h3>
                            </div>

                            <div class="card-body">
                                {{-- <p>
                                    Forneça informações mais detalhadas sobre o histórico e a abordagem do ensino para
                                    exibir no seu Perfil do professor. Se você precisar de ajuda para tornar seu perfil
                                    melhor, entre em contato conosco. <br>Observação: o Guitarpedia foi projetado quando os
                                    alunos permanecem on line. Os links para sites externos podem ser removidos ou resultar
                                    na desativação do seu perfil.
                                </p> --}}

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label for="inputYoutube">
                                            <i class="fas fa-image"></i> Imagem do perfil
                                        </label>
                                        <div class="file-avatar">
                                            <img class="img-editor imagem fr-fil fr-dib" src="@if( !$usuario->imagem || $usuario->imagem == '' || $usuario->imagem == null) {{assets('backend/images/sem-imagem.png')}} @else {{$usuario->imagem}} @endif" alt="Imagem"/>
                                            <input type="hidden" name="imagem" value="@if( !$usuario->imagem || $usuario->imagem == '' || $usuario->imagem == null) {{assets('backend/images/sem-imagem.png')}} @else {{$usuario->imagem}} @endif" class="url-imagem" id="imagem">
                                        </div>

                                        <small id="inputPhotoHelp" class="form-text text-muted">
                                            Essa foto será usada no seu perfil, lista de contatos, mensagens, etc.
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputYoutube">
                                            <i class="fas fa-images"></i> Imagens adicionais
                                        </label>
                                        <small id="inputPhotoHelp" class="form-text text-muted">
                                            Imagens adicionais para a sua página de professor.
                                        </small>
                                        <input type="file" class="galeria" name="galeria" multiple />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-0">
                                        <label for="inputYoutube">
                                            <i class="fab fa-youtube"></i> Vídeo do Youtube
                                        </label>
                                        <input type="text" name="video" id="inputYoutube" class="form-control"  value="{{ $usuario->video }}">
                                    </div>
                                    <div class="col-12">
                                        <small id="inputYoutubeHelp" class="form-text text-muted">
                                            Demonstre seus talentos em vídeo! Insira a URL de um vídeo do youtube:
                                            http://www.youtube.com/watch?v=XXXXXXXXXX
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                        SEO
                                    </div>
                                </h3>
                            </div>

                            <div class="card-body">
                                <p>
                                    Faça aqui sua o SEO de sua página
                                </p>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="" class="">Título da Página</label>
                                            <button type="button" class="btn-popover" data-container="body" data-toggle="popover"
                                                    data-trigger="hover" data-placement="right"
                                                    data-title = "Título da página"
                                                    data-content="Título que aparecerá no navegador do aluno, quando ele visualizar a sua página no Guitarpedia">
                                                <i class="fas fa-question-circle"></i>
                                            </button>
                                            <input type="text" name="titulo_seo" class="form-control" value="{{ $usuario->titulo_seo }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="" class="">Descrição da Página</label>
                                            <button type="button" class="btn-popover" data-container="body" data-toggle="popover"
                                                    data-trigger="hover" data-placement="right"
                                                    data-title = "Descrição da página"
                                                    data-content="Um pequeno texto para descrever, resumidamente, o conteúdo da sua página. Isso melhora a indexação da sua página pelo Google">
                                                <i class="fas fa-question-circle"></i>
                                            </button>
                                            <textarea name="description_seo" class="form-control">{{ $usuario->description_seo }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="" class="">Palavas Chave da Página</label>
                                            <button type="button" class="btn-popover" data-container="body" data-toggle="popover"
                                                    data-trigger="hover" data-placement="right"
                                                    data-title = "Palavras Chave da página"
                                                    data-content="Palavras chave que possam descrever o conteúdo da sua página. As palavras devem ser separadas por vírgula.">
                                                <i class="fas fa-question-circle"></i>
                                            </button>
                                            <textarea name="keywords_seo" class="form-control">{{ $usuario->keywords_seo }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                        Apresentação*
                                    </div>
                                </h3>
                            </div>

                            <div class="card-body">
                                <p>
                                    Faça aqui sua apresentação
                                </p>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea name="apresentacao" class="summernote_featured">{{ $usuario->apresentacao }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                        Texto de Destaque*
                                    </div>
                                </h3>
                            </div>

                            <div class="card-body">
                                <p>
                                    Conte-nos sobre suas experiências e realizações anteriores.
                                </p>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea name="destaque" class="summernote_featured">{{ $usuario->destaque }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Mais informações sobre mim</h3>
                            </div>

                            <div class="card-body">
                                <p>
                                    Conte-nos sobre suas experiências e realizações anteriores.
                                </p>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <textarea name="sobre" class="summernote_featured">{{ $usuario->sobre }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger elevation-0">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    <div class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                         title="Preenchimento Obrigatório"> Método de Ensino*
                                    </div>
                                </h3>
                            </div>

                            <div class="card-body">
                                <p>
                                    Conte-nos sobre suas experiências e realizações anteriores.
                                </p>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <textarea name="metodo" class="summernote_featured">{{ $usuario->metodo }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger elevation-0">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Credenciais & Afiliações</h3>
                            </div>

                            <div class="card-body">
                                <p>
                                    Forneça informações detalhadas para os administradores do Guitarpedia. Esta
                                    informação será mantida em sigilo e não será exibida em seu perfil.
                                </p>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <textarea name="credenciais" class="summernote_featured">{{ $usuario->credenciais }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger elevation-0">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Sobre alunos</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                Para ensinar alunos com menos de 18 anos, os professores devem passar por
                                                uma verificação de antecedentes. <br>
                                                <b>Você pretende dar aulas para menores de 18 anos?</b>
                                            </label>
                                            <div class="form-check">
                                                <input class="form-check-input" id="sobre-1" type="radio" name="sobre_alunos" value="1" @if( $usuario->sobre_alunos == 1) checked @endif>
                                                <label class="form-check-label" for="sobre-1">SIM</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="sobre-2" type="radio" name="sobre_alunos" value="2" @if( $usuario->sobre_alunos == 2) checked @endif>
                                                <label class="form-check-label" for="sobre-2">NÃO</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-20 padding-right-40 margin-bottom-30 horizontal-right btn-salvar">
                            <button class="btn btn-danger" type="submit">
                                Salvar <i class="fas fa-save ml-1"></i>
                            </button>
                            <a class="btn btn-success margin-left-10" href="{{ route('sistema.aluno.aovivo.professor', $usuario->slug) }}" target="_blank">
                                Visualizar Página <i class="fas fa-eye ml-1"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-3"></div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-sm" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Solicitar nova categoria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body padding-20">
            <form data-action="{{ route('sistema.dash-professor.nova-categoria') }}" class="form-normal">
                <div class="row">
                    <label for="" class="text-red text-12-pt bold">Envie-nos uma mensagem, informando a categoria que deseja ser adicionada:</label>
                    <textarea name="mensagem" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="row margin-top-20 horizontal-right">
                    <button class="btn btn-danger" type="submit">Enviar</button>
                </div>
            </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@section('scripts')
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>
    <script src="{{assets('plugins/js')}}/endereco.js"></script>
    <link href="{{assets('backend/plugins/froala/css/froala_editor.pkgd.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{assets('backend/plugins/froala/css/froala_style.min.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{assets('backend/plugins/froala/js/froala_editor.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{assets('backend/plugins/froala/js/languages/pt_br.js')}}"></script>
    <link href="{{assets('bower_components/toastr/toastr.css')}}" rel="stylesheet">
    <script src="{{assets('bower_components/toastr/toastr.js')}}"></script>
    <script>
        var routes = {
          sistema:{
            produto:{
              upload: '{{ route('sistema.dash-professor.avatar.upload', $usuario->id) }}'
            }
          }
        };
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/locales/pt-BR.js"></script>
  <script>
    var $token = "{{ csrf_token() }}";
    $(document).ready(function(){
        @error('categorias')
            new swal({
                title: 'Oops...',
                html: 'Você precisa completar seu cadastro para continuar...',
                icon: 'error'
            }).then((result) => {
            });
        @enderror
        @php
          $galeria = [];
          foreach( $usuario->imagens as $g ){
            $galeria[] = $g;
          }
        @endphp
        @if( is_array( $galeria ) && !empty( $galeria ) )
          @foreach( $galeria as $v )
            var url{{$v->id}} = '{{url('storage/app/public/professoraovivo/') .'/'. $usuario->id . '/' .$v->imagem}}';
          @endforeach
        @endif
        var $inputg = jQuery('.galeria');
        $inputg.fileinput({
          uploadExtraData: function() {
            return {
                _token: $token,
                produto:  '{{$usuario->id}}'
            };
          },
          @if( is_array($galeria) && !empty( $galeria ) )
            initialPreviewAsData: true,
            initialPreview: [@foreach( $galeria as $v ) url{{$v->id}},@endforeach],
            initialPreviewConfig: [
             @foreach( $galeria as $v )
              @php
                $dir = 'professoraovivo/' . $usuario->id . '/';
                $arquivo = $dir . '/' . $v->imagem;
              @endphp
              {
                @if(Storage::exists($arquivo))
                    size: @php echo Storage::size($arquivo) > 0 ? Storage::size($arquivo) : 0; @endphp,
                @endif
                caption: "", 
                key: {{$v->id}},
                downloadUrl: '{{ url('storage/app/public/professoraovivo/') .'/'. $usuario->id . '/' .$v->imagem}}', 
                filename: '{{$v->imagem}}',
                extra: { _token: $token }
              },
              @endforeach
            ],
            @endif
            language: "pt-BR",
            previewFileType: 'image',
            overwriteInitial: false,
            @if( is_array( $galeria ) && !empty( $galeria ) )
              deleteUrl: "{{route('sistema.dash-professor.imagens.apagar', [$usuario->id])}}",
            @endif
            maxFileSize: 10000,
            showClose: false,
            showCaption: true,
            showBrowse: true,
            browseOnZoneClick: true,
            removeLabel: 'Remover',
            allowedFileTypes: ["image"],
            allowedFileExtensions: ["png", "jpg", "jpeg", "gif"],
            showUpload: false,
            uploadUrl: "{{route('sistema.dash-professor.imagens', [$usuario->id])}}",
            uploadAsync: true,
            maxFileCount: 0,
            theme: 'fas'
        });

        $inputg.on('filebeforedelete', function(jqXHR) {
            return new swal({
                title: 'Atenção!',
                html: 'Confirma a exclusão desta imagem?',
                icon: 'question',
                confirmButtonText: "Sim",
                showCancelButton: true,
                cancelButtonText: "Não",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.value) {
                    return false;
                }else{
                    return true;
                }
            });
        });

        $inputg.on("filebatchselected", function(event, files) {
            $(this).fileinput("upload"); 
        });
        
        $inputg.on('filebatchuploadcomplete', function(event, files, extra) {
            new swal({
                title: 'Tudo certo',
                html: 'Imagens salvas com sucesso!',
                icon: 'success'
            }).then((result) => {
                //window.location.reload();
            });
        });
    })
  </script>
@endsection