@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_evaluation">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-star"></i> Avaliações</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT HEADER -->

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0 text-danger text-bold text-center">
                                <span><b>Listas de Avaliações que Recebi</b></span>
                                <div class="evaluation">
                                    <input name="rate_professor" value="{{ currencyToAppDot($usuario->avaliacao) }}" class="kv-ltr-theme-svg-star rating-loading" value="0" step="0.5" dir="ltr" data-size="xs">
                                    <span>{{ $usuario->avaliacoes->where('ocorreu', '!=', 0)->count() }} comentários</span>
                                </div>
                                {{--  <span><i class="fas fa-star mr-1"></i> {{ $usuario->avaliacao }} ({{ $usuario->avaliacoes->where('ocorreu', '!=', 0)->count() }})</span>  --}}
                                {{-- <span>Você tem <b>12</b> novas avaliações</span> --}}
                            </h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered text-12-pt">
                                <thead>
                                    <tr>
                                        <th>Nome do Aluno</th>
                                        <th>Categoria</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($usuario->avaliacoes->where('ocorreu', '!=', 0) as $a)
                                        <tr class="linha-avaliar">
                                            <td>{{ $a->aluno->fullName }}</td>
                                            <td>{{ $a->agendamento->aula->categoria->nome }}</td>
                                            <td>
                                                @if($a->agendamento->status != 5)
                                                    {{ dateBdToApp($a->agendamento->data) }} às {{ $a->agendamento->inicio }}
                                                @endif
                                            </td>
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
                                                @if($a->agendamento->status == 4)
                                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_disputa_{{ $loop->index }}">
                                                        <i class="fas fa-check-circle padding-right-10"></i>Verificar Aula
                                                    </button>
                                                @endif
                                                @if($a->agendamento->status == 3 || $a->agendamento->status == 6)
                                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_{{ $loop->index }}" data-tg="tooltip" title="Ver avaliação">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                @endif
                                                @if($a->exibir == 1)
                                                    <button type="button" class="btn btn-sm btn-danger btn-remove-comentario submit-single-post" data-texto="Confirma a remoção deste comentário de sua página?" data-url="{{ route('sistema.dash-professor.avaliacao.remover', $a->id) }}" data-toggle="tooltip" title="Remover comentário de sua página">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                                <div class="modal fade" id="modal_{{ $loop->index }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="modal_{{ $loop->index }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Comentário</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                {{ $a->comentario_aluno }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <span><b>Avaliação</b></span>
                                                                <input name="rate_professor" value="{{ currencyToAppDot($a->rate_professor) }}" class="kv-ltr-theme-svg-star rating-loading" value="0" step="0.5" dir="ltr" data-size="xs">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modal_disputa_{{ $loop->index }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="modal_disputa_{{ $loop->index }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"> Motivo da não execução </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                {{ $a->comentario_aluno }}
                                                            </div>
                                                            <div class="modal-footer row">
                                                                <div class="col-6">
                                                                    <div class="row">
                                                                        <button class="btn btn-sm btn-success submit-single-post" data-texto="<b>Essa ação irá encerrar esta disputa</b>, e marcará a aula como realmente executada. Confirma?" data-url="{{ route('sistema.dash-professor.avaliacao.encerrar', $a->id) }}">
                                                                            <i class="fas fa-check padding-right-10"></i>A Aula Foi Realizada
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="row horizontal-right">
                                                                        <button class="btn btn-sm btn-primary submit-single-post" data-texto="Ao fazer isso,você está <b>confirmando que a aula não ocorreu,</b> e permitirá ao aluno reagendar a mesma. Confirma?" data-url="{{ route('sistema.dash-professor.avaliacao.reagendar', $a->id) }}">
                                                                            <i class="far fa-thumbs-up margin-right-10"></i>Permitir Reagendamento
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0 text-danger text-bold">
                                <span><b>Listas de Avaliações dos Alunos</b></span>
                                {{-- <span>Você já avaliou <b>05</b> alunos</span> --}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group d-none d-md-block mb-3">
                                <div class="row text-center text-danger">
                                    <div class="col-12 col-md-4">
                                        <li class="list-group-item border rounded">
                                            Nome do aluno
                                        </li>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <li class="list-group-item border rounded">
                                            Categoria
                                        </li>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <li class="list-group-item border rounded">
                                            Avaliar
                                        </li>
                                    </div>
                                </div>
                            </ul>

                            @forelse($usuario->avaliacoes as $a)
                                <ul class="list-group mb-3">
                                    <div class="row text-center text-danger">
                                        <div class="col-12 col-md-4">
                                            <li class="list-group-item border rounded">
                                                {{ $a->aluno->fullName }}
                                            </li>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <li class="list-group-item border rounded">
                                                {{ $a->agendamento->aula->categoria->nome }}
                                            </li>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <li class="list-group-item border-0">
                                                <button type="button" data-toggle="modal"
                                                        data-target="#modal_p_{{ $loop->index }}">
                                                    <i class="far fa-check-circle"></i>
                                                </button>

                                                <div class="modal fade" id="modal_p_{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="modal_p_{{ $loop->index }}Label" aria-hidden="true">
                                                    <form data-action="{{ route('sistema.dash-professor.avaliacao.gravar') }}" class="form-normal">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Comentários
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-left">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <input type="hidden" name="id" value="{{ $a->id }}">
                                                                            <textarea name="comentario_professor" id="comentario_{{ $a->id }}" cols="30" rows="10" class="form-control">{{ $a->comentario_professor }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-danger" type="submit">
                                                                        Salvar <i class="fas fa-save ml-1"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </li>
                                        </div>
                                    </div>
                                </ul>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MAIN CONTENT -->
</div>
@endsection

@section('scripts')
    <script src="{{assets('sistema/js/jquery.mask.js')}}"></script>        
    <script src="{{assets('plugins/js/masks.js')}}"></script>
    <link href="{{ assets('sistema/alunos/dist/stars/css/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ assets('sistema/alunos/dist/stars/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <script src="{{ assets('sistema/alunos/dist/stars/js/star-rating.min.js') }}" type="text/javascript"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/themes/krajee-uni/theme.js') }}"></script>
    <script src="{{ assets('sistema/alunos/dist/stars/js/locales/pt-BR.js') }}"></script>
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css" media="all" rel="stylesheet" type="text/css" />
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
    <style>
        .rating-container .filled-stars {
            color: #5335a0 !important;
            -webkit-text-stroke: initial;
            text-shadow: 1px 1px 5335a0;
        }
        
        .rating-xs {
            font-size: 22px !important;
        }

        .btn-danger{
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }
        .btn-danger:hover{
            color: #fff !important;
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
        }
        
    </style>
    <script>
        $(document).ready(function(){
            $("[data-tg=tooltip]").tooltip();
            $('.kv-ltr-theme-svg-star').rating({
                hoverOnClear: false,
                theme: 'krajee-uni',
                language: 'pt-BR',
                showCaption: false,
                showClear: false,
                animate: false,
                readonly: true,
            });

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
        });
    </script>
@endsection