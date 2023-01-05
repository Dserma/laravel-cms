@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_classes_create">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-briefcase"></i> Pacote de Aulas</h1>
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
                        <div class="card-body">
                            <form data-action="{{ route('sistema.dash-professor.pacotes.salvar') }}" class="form-normal">
                                <input type="hidden" name="id" value="" class="id">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="inputClasses" class="mb-0">Aula</label>
                                        <small class="form-text text-danger mt-0 mb-2">
                                            Selecione uma aula para criar os pacotes
                                        </small>
                                        {!! Form::select('aulaaovivo_id',[null => 'Selecione'] + $aulas, null, ['class' => 'select2 form-control']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="inputAmount">Quantidade de Aulas</label>
                                        <input type="number" min="2" max="99" step="1" name="quantidade" id="inputAmount" class="form-control" placeholder="Digite a Quantidade">
                                    </div>

                                    <div class="form-group col-12 col-md-6">
                                        <label for="inputDiscount">Percentual de Desconto ( em % )</label>
                                        <input type="text" name="desconto" id="inputAmount" class="form-control dinheiro-input-mask" placeholder="Digite o desconto">
                                    </div>
                                </div>

                                <div class="row">
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
                            <h5 class="m-0 text-danger text-bold"><i class="fas fa-list"></i> Listagem de Pacotes</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Aula</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Desconto</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usuario->pacotes as $pacote)
                                            <tr>
                                                <td scope="row">{{ $pacote->aula->categoria->nome . ' - ' . $pacote->aula->duracao . ' minutos - ' . currencyToApp($pacote->aula->valor) }}</td>
                                                <td>{{ $pacote->quantidade }} aulas</td>
                                                <td>{{ $pacote->desconto }}%</td>
                                                <td>
                                                    <a class="mr-3 btn-alterar" href="#" data-url="{{ route('sistema.dash-professor.get', ['pacoteaulaaovivo', $pacote->id]) }}"><i class="fas fa-edit"></i></a>
                                                    <a href="#" data-url="{{ route('sistema.dash-professor.excluir', ['pacoteaulaaovivo', $pacote->id]) }}" data-texto="Confirma a exclusão deste pacote de aulas?" class="submit-single-post"><i class="fas fa-trash-alt"></i></a>
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
@endsection