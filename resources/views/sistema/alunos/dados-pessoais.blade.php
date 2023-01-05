@extends('sistema.alunos.layouts.default')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header  pl-2 pl-xl-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-user-lock"></i> Dados Pessoais</h1>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row pl-0 pl-xl-3 padding-bottom-45">
                <div class="col-md-12">
                    <div class="row padding-5 padding-left-20 title-form">
                        <h3>Informações Básicas</h3>
                    </div>
                    <form data-action="{{ route('sistema.alunos.dados.salvar') }}" class="form-normal">
                        <input type="hidden" name="id" value="{{ $usuario->id }}">
                        <div class="row formulario-padrao">
                            <div class="col-xl-6 padding-top-10">
                                <div class="row padding-top-10 padding-bottom-10">
                                    <div class="col-xl-6 pl-0">
                                        <label>Nome*</label>
                                        <input type="text" name="nome" value="{{ $usuario->nome }}" />
                                    </div>
                                    <div class="col-xl-6 pl-0 pl-xl-1 mt-4 mt-xl-0">
                                        <label>Sobrenome*</label>
                                        <input type="text" name="sobrenome" value="{{ $usuario->sobrenome }}" />
                                    </div>
                                </div>
                                <div class="row padding-top-10 padding-bottom-10">
                                    <div class="col-xl-6 pl-0 telefone">
                                        <label>Telefone</label>
                                        <input type="tel" name="telefone" value="{{ $usuario->telefone }}"/>
                                    </div>
                                    <div class="col-xl-6 pl-0 pl-xl-1 mt-4 mt-xl-0 telefone">
                                        <label>Whatsapp*</label>
                                        <input type="text" name="whatsapp" value="{{ $usuario->whatsapp }}" />
                                    </div>
                                </div>
                                <div class="row padding-top-10 padding-bottom-10">
                                    <label for="inputEmail">País</label>
                                    {!! Form::select('pais', [null => 'Selecione', '1' => 'Brasil', 2 => 'Outros'], $usuario->pais, ['class' => 'form-control pais']) !!}
                                </div> 
                                <div class="row padding-top-10 padding-bottom-10">
                                    <div class="col-xl-12">
                                        <label>E-mail*</label>
                                        <input type="email" name="email" value="{{ $usuario->email }}" />
                                    </div>
                                </div>
                                <div class="row padding-top-10 padding-bottom-10">
                                    <div class="col-xl-12">
                                        <label>Idiomas</label>
                                        <input type="text" name="idiomas" value="{{ $usuario->idiomas }}" />
                                    </div>
                                </div>
                                <div class="row padding-top-10 padding-bottom-10">
                                    <div class="col-xl-12">
                                        <label>Aulas que desejo aprender</label>
                                        <input type="text" name="aprender" value="{{ $usuario->aprender }}" />
                                    </div>
                                </div>
                                <div class="row padding-top-10 padding-bottom-10">
                                    <div class="col-xl-8">
                                        <label>Time Zone</label>
                                        {!! Form::select('zone_id', [null => 'Selecione'] + $zonas, $usuario->zone_id, ['class' => 'select2']) !!}
                                    </div>
                                </div>
                                <div class="endereco">
                                    <div class="row padding-top-10 padding-bottom-10">
                                        <div class="col-xl-6 pl-0 cep">
                                            <label>CEP</label>
                                            <input type="tel" name="cep" class="cep cep-input-mask" value="{{ $usuario->cep }}" />
                                        </div>
                                        <div class="col-xl-6 pl-0 pl-xl-1 mt-4 mt-xl-0">
                                            <label>Logradouro*</label>
                                            <input type="text" name="logradouro" class="logradouro" value="{{ $usuario->logradouro }}"/>
                                        </div>
                                    </div>
                                    <div class="row padding-top-10 padding-bottom-10">
                                        <div class="col-xl-4 pl-0">
                                            <label>Número</label>
                                            <input type="tel" name="numero" class="numero" value="{{ $usuario->numero }}"/>
                                        </div>
                                        <div class="col-xl-8 pl-0 pl-xl-1 mt-4 mt-xl-0">
                                            <label>Complemento</label>
                                            <input type="text" name="complemento" class="complemento"value="{{ $usuario->complemento }}" />
                                        </div>
                                    </div>
                                    <div class="row padding-top-10 padding-bottom-10">
                                        <div class="col-xl-12">
                                            <label>Bairro</label>
                                            <input type="text" name="bairro" class="bairro" value="{{ $usuario->bairro }}"/>
                                        </div>
                                    </div>
                                    <div class="row padding-top-10 padding-bottom-10">
                                        <div class="col-xl-10 pl-0">
                                            <label>Cidade</label>
                                            {!! Form::select('city_id', [null => ''] + $cidades, $usuario->present()->cidade($usuario->city_id), ['class' => 'localidade select2 form-control']) !!}
                                        </div>
                                        <div class="col-xl-2 pl-0 pl-xl-1 mt-4 mt-xl-0">
                                            <label>UF</label>
                                            {!! Form::select('state_id', [null => ''] + $estados, $usuario->present()->estado($usuario->state_id), ['class' => 'uf select2 form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl-0 pl-xl-4 padding-top-10">
                                <div class="row padding-top-10 padding-bottom-10 foto">
                                    <div class="col-lg-12">
                                        <label>Foto de perfil</label>
                                        <div class="input-group">
                                            <img class="img-editor imagem fr-fil fr-dib" src="@if( !$usuario->imagem || $usuario->imagem == '' || $usuario->imagem == null) {{assets('backend/images/sem-imagem.png')}} @else {{$usuario->imagem}} @endif" alt="Imagem"/>
                                            <input type="hidden" name="imagem" value="" class="url-imagem" id="imagem">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row padding-5 padding-left-20 margin-top-35 title-form">
                            <h3>Nova Senha <small>(deixe em branco para continuar com a a senha atual)</small></h3>
                        </div>

                    <div class="row formulario-padrao">
                        <div class="col-xl-6 padding-top-10">
                            <div class="row padding-top-10 padding-bottom-10">
                                <div class="col-lg-12 pr-0 pr-xl-1">
                                    <label>Criar Senha</label>
                                    <input type="password" name="senha" />
                                </div>
                            </div>
                            <div class="row padding-top-10 padding-bottom-10">
                                <div class="col-lg-12 pr-0 pr-xl-1 telefone">
                                    <label>Confirmar Senha</label>
                                    <input type="password" name="senha_confirmation" />
                                </div>
                            </div>
                            <div class="row padding-top-10 padding-bottom-10">
                                <div class="col-lg-4 padding-right-5 botao-save">
                                    <button type="submit">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>

@stop
@section('scripts')
    <link rel="stylesheet" href="{{assets('bower_components/select2/dist/css/select2.min.css')}}">
    <script src="{{assets('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>
    <script src="{{assets('plugins/js')}}/endereco.js"></script>
    <link href="{{assets('backend/plugins/froala/css/froala_editor.pkgd.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{assets('backend/plugins/froala/css/froala_style.min.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{assets('backend/plugins/froala/js/froala_editor.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{assets('backend/plugins/froala/js/languages/pt_br.js')}}"></script>
    <script>
        var routes = {
          sistema:{
            produto:{
              upload: '{{ route('sistema.alunos.upload', $usuario->id) }}'
            }
          }
        };
      </script>
      @if( $request->pais == 'false' )
        <script>
            $(document).ready(function(){
                new swal({
                    title: 'Oops...',
                    html: 'Por favor, selecione o seu país para completar seu cadastro',
                    icon: 'error'
                }).then((result) => {
                    if (result.value) {
                        $target = $('.pais').offset().top - 50;
                        $('html, body').animate({ scrollTop: $target }, 800);
                        $('.pais').focus();
                    }
                });
            })
        </script>
      @endif
@stop
    