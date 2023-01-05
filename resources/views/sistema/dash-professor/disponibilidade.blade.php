@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_availability">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-user-check"></i> Disponibilidade</h1>
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
                        <div class="card-header border-0">
                            <h3 class="card-title text-danger">
                                Digite os campos de tempo que você deseja disponibilizar para as aulas. Utilize as exceções de disponibilidade para definir horários em que você não estará disponível, como em feriados ou em passeios.
                            </h3>
                            @error('disponibilidades')
                                <div class="row margin-top-30 text-red bold text-20-pt">
                                    Você ainda não possui nenhuma disponibilidade cadastrada!. Por favor, cadastre ao menos um período de disponibilidade.
                                </div>
                            @enderror
                        </div>
                        <div class="card-body">
                            <form data-action="{{ route('sistema.dash-disponibilidade.salvar') }}" class="form-normal">
                                <input type="hidden" name="id" value="" class="id">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputDateStart">
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preenchimento Obrigatório">
                                                    Data de Início*
                                                </div>
                                            </label>
                                            <div class="input-group date" id="dateStart" data-target-input="nearest">
                                                <input type="text" name="inicio" id="inputDateStart" class="form-control datetimepicker-input data-input-mask" data-target="#dateStart"/>
                                                <div class="input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <small class="form-text text-danger">
                                                Selecione o primeiro dia em que esta programação se aplica.
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputDateEnd">Data de Término</label>
                                            <div class="input-group date" id="dateEnd" data-target-input="nearest">
                                                <input type="text" name="fim" id="inputDateEnd" class="form-control datetimepicker-input data-input-mask" data-target="#dateEnd"/>
                                                <div class="input-group-append" data-target="#dateEnd" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <small class="form-text text-danger">
                                                Selecione o último dia em que esta programação se aplica. Deixe em
                                                branco para uma final.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-4 px-0 px-md-5">
                                        <span>Dias</span>
                                        <div class="form-group dias check-group">
                                            <div class="form-check">
                                                <input class="form-check-input" id="dia_1" type="checkbox" name="dias[]" value="1">
                                                <label class="form-check-label" for="dia_1">Segunda-Feira</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="dia_2" type="checkbox" name="dias[]" value="2">
                                                <label class="form-check-label" for="dia_2">Terça-Feira</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="dia_3" type="checkbox" name="dias[]" value="3">
                                                <label class="form-check-label" for="dia_3">Quarta-Feira</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="dia_4" type="checkbox" name="dias[]" value="4">
                                                <label class="form-check-label" for="dia_4">Quinta-Feira</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="dia_5" type="checkbox" name="dias[]" value="5">
                                                <label class="form-check-label" for="dia_5">Sexta-Feira</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="dia_6" type="checkbox" name="dias[]" value="6">
                                                <label class="form-check-label" for="dia_6">Sábado</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="dia_0" type="checkbox" name="dias[]" value="0">
                                                <label class="form-check-label" for="dia_0">Domingo</label>
                                            </div>
                                            <small class="form-text text-danger">
                                                Selecione os dias aos quais esta programação se aplica
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputTimeStart">Hora de Início</label>
                                            <div class="input-group date" id="timeStart" data-target-input="nearest">
                                                <input type="text" name="hora_inicio" id="inputTimeStart" class="form-control datetimepicker-input hora-curta-input-mask" data-target="#timeStart"/>
                                                <div class="input-group-append" data-target="#timeStart" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputTimeEnd">Hora de Término</label>
                                            <div class="input-group date" id="timeEnd" data-target-input="nearest">
                                                <input type="text" name="hora_fim" id="inputTimeEnd" class="form-control datetimepicker-input hora-curta-input-mask" data-target="#timeEnd"/>
                                                <div class="input-group-append" data-target="#timeEnd" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputStudent">Reservar para o Aluno</label>
                                            <button type="button" class="btn-popover" data-container="body" data-toggle="popover"
                                                data-trigger="hover" data-placement="right"
                                                data-title = "Reservar para o Aluno"
                                                data-content="Aqui você pode reservar a disponibilidade para um único aluno, evitando assim que outros utilizem esses horários">
                                            <i class="fas fa-question-circle"></i>
                                                    </button>
                                            {!! Form::select('aluno_id', [null => 'Selecione'] +  $alunos, null, ['class' => 'form-control select2']) !!}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-danger" type="submit">
                                            Salvar <i class="fas fa-save ml-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header border-0">
                            <h5 class="m-0 text-danger text-bold">
                                <i class="fas fa-list"></i> Listagem de Disponibilidades 
                                <button class="help" type="button" data-container="body" data-toggle="popover"
                                        data-trigger="hover" data-placement="right"
                                        data-title = "Ordenação"
                                        data-content="Clique no campo de ordem e arraste, para alterar a ordenação">
                                    <i class="fas fa-question-circle"></i>
                                </button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Ordem</th>
                                            <th scope="col" style="display: none">id</th>
                                            <th scope="col">Data de Início</th>
                                            <th scope="col">Data de Término</th>
                                            <th scope="col">Dia da Semana</th>
                                            <th scope="col">Horário de Início</th>
                                            <th scope="col">Horário de Término</th>
                                            <th scope="col">Aluno</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse( $usuario->disponibilidades->sortBy('order') as $disp )
                                            <tr class="bold">
                                                <td>{{ $disp->order }}</td>
                                                <td style="display: none">{{ $disp->id }}</td>
                                                <td>{{ dateBdToApp($disp->inicio) }}</td>
                                                <td>{{ dateBdToApp($disp->fim) }}</td>
                                                <td>{{ $usuario->present()->dias($disp) }}</td>
                                                <td>{{ $disp->hora_inicio }}</td>
                                                <td>{{ $disp->hora_fim }}</td>
                                                <td>{{ $disp->aluno()->exists() ? $disp->aluno->fullName : '' }}</td>
                                                <td>
                                                    <a class="mr-3 btn-alterar" href="#" data-url="{{ route('sistema.dash-professor.get', ['disponibilidadeprofessoraovivo', $disp->id]) }}"><i class="fas fa-edit"></i></a>
                                                    <a href="#" data-url="{{ route('sistema.dash-professor.excluir', ['disponibilidadeprofessoraovivo', $disp->id]) }}" data-texto="Confirma a exclusão desta disponibilidade?" class="submit-single-post"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
    <script src="{{assets('sistema/js')}}/jquery.mask.js"></script>        
    <script src="{{assets('plugins/js')}}/masks.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
    {{--  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <style>
        .table tbody tr td:first-of-type{
            cursor: grabbing;
        }
        .help{
            border: none;
            background: transparent;
            font-size: 14px;
        }
    </style>
    <script>
        $(document).ready(function() {
            var table = $('.table').DataTable( {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Portuguese-Brasil.json"
                },
                paging:   false,
                searching:   false,
                ordering: false,
                info:     false,
                rowReorder: true
            } );

        table.on( 'row-reordered', function ( e, diff, edit ) {
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table.row( diff[i].node ).data();
                alteraOrdem(table.row( diff[i].node ).data()[1], diff[i].newPosition+1);
            }
          });
          function alteraOrdem(id, pos) {
            $.ajax({
              url: '{{route('sistema.professor.disponibilidade.reorder')}}',
              headers: {
                'X-CSRF-Token': $('meta[name=_token]').attr('content')
              },
              async: true,
              method: 'POST',
              data: {sid: Math.random, i: id, p: pos},
              success: function (data) {
                  window.location.reload();
              },
              beforeSend: function () {
              },
              complete: function () {}
            });
          }
          } );
    </script>
@endsection