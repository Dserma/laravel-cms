@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_classes_create">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-video"></i> Crie uma Aula</h1>
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
                            <form data-action="{{ route('sistema.dash-professor.aulas.salvar') }}" class="form-normal">
                                <input type="hidden" name="id" value="" class="id">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="inputClasses" class="mb-0">Categoria de Aulas</label>
                                        <small class="form-text text-danger mt-0 mb-2">
                                            Selecione os tópicos que você está mais qualificado para ensinar
                                        </small>
                                        {!! Form::select('categoriaaovivo_id',[null => 'Selecione'] + $categorias, null, ['class' => 'select2 form-control']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="inputAmount">Duração das Aulas ( em minutos )</label>
                                        <input name="duracao" type="number" min="15" max="240" step="5" id="inputAmount" class="form-control" placeholder="Digite a Duração...">
                                    </div>

                                    <div class="form-group col-12 col-md-6">
                                        <label for="inputPrice">Valor</label>
                                        <input type="text" name="valor" id="inputPrice" class="form-control dinheiro-input-mask" placeholder="R$ 00,00">
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
                            <h5 class="m-0 text-danger text-bold"><i class="fas fa-list"></i> Listagem de Aulas</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Categoria de Aula</th>
                                            <th scope="col">Duração</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usuario->aulas as $aula)
                                            <tr>
                                                <td scope="row">{{ $aula->categoria->nome }}</td>
                                                <td>{{ $aula->duracao }} minutos</td>
                                                <td>{{ currencyToApp($aula->valor) }}</td>
                                                <td>
                                                    <a class="mr-3 btn-alterar" href="#" data-url="{{ route('sistema.dash-professor.get', ['aulaaovivo', $aula->id]) }}"><i class="fas fa-edit"></i></a>
                                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
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