@extends('sistema.alunos.layouts.default')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"> <i class="fas fa-star"></i> Avaliações </h1>
                    <!-- <span class="right badge badge-danger">New</span> -->

                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Dashboard v1</li>
    </ol> -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row padding-left-20">
                <div class="col-12">
                    <div class="card card-primary card-border-azul">
                        <div class="card-header-custom-gray padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                            <div class="row">
                                <div class="col-lg-6 text-20-pt bold">
                                    <h3 class="text-20-pt bold">Avalie suas Aulas ao Vivo</h3>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <h3>Você ja avaliou <b class="roxo">{{ $usuario->avaliacoes->where('status',1)->count() }}</b> aulas </h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body padding-30 table-responsive padding-bottom-200">
                            <table class="table table-striped table-bordered text-16-pt">
                                <thead>
                                    <tr>
                                        <th>Nome do Professor</th>
                                        <th>Categoria</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($usuario->avaliacoes as $a)
                                        @if( $a->agendamento )
                                            <tr class="linha-avaliar">
                                                <td>{{ $a->professor->fullName }}</td>
                                                <td>{{ $a->agendamento->aula->categoria->nome }}</td>
                                                <td>{{ dateBdToApp($a->agendamento->data) }} às {{ $a->agendamento->inicio }}</td>
                                                <td>
                                                    @if($a->agendamento->status == 2)
                                                        <span class="badge badge-warning">Aguardando Avaliação</span>
                                                    @endif
                                                    @if($a->agendamento->status == 3)
                                                        <span class="badge badge-success">Aula Executada</span>
                                                    @endif
                                                    @if($a->agendamento->status == 4)
                                                        <span class="badge badge-danger">Aula Não Executada</span>
                                                    @endif
                                                    @if($a->agendamento->status == 5)
                                                        <span class="badge badge-primary">Aguardando Reagendamento</span>
                                                    @endif
                                                    @if($a->agendamento->status == 6)
                                                        <span class="badge badge-info">Disputa Encerrada</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if( $a->ocorreu == 0 )
                                                        <button class="btn btn-sm btn-success btn-avaliar"><i class="fas fa-check"></i> Avaliar</button>
                                                        <form data-action="{{ route('sistema.alunos.aovivo.avaliacao.avaliar', $a->id) }}" class="comentario {{ $a->ocorreu == 0 ? 'form-normal' : 'form' }}">
                                                            <div class="col-12">
                                                                <div class="row padding-10">
                                                                    <label for="" class="text-red text-18-pt bold">A Aula Aconteceu?</label>
                                                                </div>
                                                                <div class="row padding-left-10 vertical-middle">
                                                                    <div class="icheck-primary d-inline text-gray text-22-pt">
                                                                        <input type="radio" id="ocorreu_{{ $a->id }}" name="ocorreu" value="1" required>
                                                                        <label for="ocorreu_{{ $a->id }}" class="medium">
                                                                            SIM
                                                                        </label>
                                                                    </div>
                                                                    <div class="icheck-primary d-inline text-gray text-22-pt padding-left-20">
                                                                        <input type="radio" id="nao_ocorreu_{{ $a->id }}" name="ocorreu" value="2" required>
                                                                        <label for="nao_ocorreu_{{ $a->id }}" class="medium">
                                                                            NÃO
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row margin-top-10">
                                                                    <textarea name="comentario_aluno" id="" cols="30" rows="10" class="form-control" placeholder="Digite seu Comentário:"></textarea>
                                                                </div>
                                                                <div class="row margin-top-10 padding-right-20 padding-bottom-10 horizontal-right vertical-middle">
                                                                    <div class="col-lg-2 padding-left-20">
                                                                        <button class="btn-danger text-16-pt btn-small btn-avaliar" type="button">Fechar</button>
                                                                    </div>
                                                                    <div class="col-lg-8 horizontal-right">
                                                                        <span class="quick text-gray text-14-pt bold padding-right-10 padding-top-5">Avaliação</span>
                                                                        <input id="input-2-ltr-star-sm" name="rate_professor" class="kv-ltr-theme-svg-star rating-loading" value="0" step="0.5" dir="ltr" data-size="xs">
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="row horizontal-right">
                                                                            <button class="btn-purple text-16-pt btn-small" type="submit">Avaliar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                {{--  <div class="col-md-6 padding-left-25">
                    <div class="card card-primary card-border-azul depoimento">
                        <div class="card-header-custom-gray padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3>Você esta gostando do Guitarpedia? Deixe seu Depoimento.</h3>
                                </div>
                                <div class="col-lg-4 text-right"></div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <textarea class="textarea" placeholder="Place some text here" id="summernote"></textarea>
                        </div>
                        <div class="card-footer">
                            <div class="row horizontal-right">
                                <a href="#" class="btn-purple text-16-pt btn-small">Salvar</a>
                            </div>
                        </div>
                    </div>  --}}
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
    <link href="{{ assets('sistema/alunos/dist/stars/css/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ assets('sistema/alunos/dist/stars/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="{{ assets('sistema/alunos/dist/stars/js/star-rating.min.js') }}" type="text/javascript"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/themes/krajee-uni/theme.js') }}"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/js/locales/pt-BR.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function(){
            tabela = $('.table').not('.normal').DataTable({
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Portuguese-Brasil.json"
                },
                "order": [
                    [0, "asc"]
                ],
                select: false,
                'paging': true,
                "pageLength": 100,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                dom: 'lBfrtip',
                buttons: [
                'copy', 'csv', 'pdf', 'print',
                ]
            });
            $( document ).ajaxComplete(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('.kv-ltr-theme-svg-star').rating({
                hoverOnClear: false,
                theme: 'krajee-uni',
                language: 'pt-BR',
                showCaption: false,
                showClear: false,
                animate: false
            });

            $('.btn-avaliar').click(function(){
                $(this).parents('.linha-avaliar').find('.comentario').toggleClass('show');
            });
        });
    </script>
@stop
