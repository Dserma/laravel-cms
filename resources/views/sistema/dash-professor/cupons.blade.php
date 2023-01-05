@extends('sistema.dash-professor.layouts.default')
@section('content')

<div class="view_classes_create">
    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0" style="color: #666666;"><i class="fas fa-tags"></i> Cupons de Desconto</h1>
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
                            <form data-action="{{ route('sistema.dash-professor.cupons.salvar') }}" class="form-normal">
                                <input type="hidden" name="id" value="" class="id">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-12">
                                        <label for="inputClasses" class="mb-0">Categoria de Aula</label>
                                        <small class="form-text text-danger mt-0 mb-2">
                                            Selecione uma categoria
                                        </small>
                                        {!! Form::select('categoriaaovivo_id',[null => 'Selecione'] + $categorias, null, ['class' => 'form-control categoria-cupom', 'data-url' => route('sistema.dash-professor.get-aulas')]) !!}
                                    </div>
                                    <div class="form-group col-lg-3 col-12">
                                        <label for="inputClasses" class="mb-0">Aula <i class="fas fa-question-circle" data-trigger="hover" data-toggle="popover" title="Aplicação de Cupons" data-content="Cada cupom só poderá ser aplicado a UMA aula específica"></i></label>
                                        <small class="form-text text-danger mt-0 mb-2">
                                            Selecione uma aula
                                        </small>
                                        <div class="aulas">
                                            {!! Form::select('aulaaovivo_id',[null => 'Selecione uma categoria'] + $aulas, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3 col-12">
                                        <label for="inputClasses" class="mb-0">Data de Validade</label>
                                        <small class="form-text text-danger mt-0 mb-2">
                                            Selecione a data de validade deste cupom
                                        </small>
                                        <div class="input-group date" id="dateStart" data-target-input="nearest">
                                            <input type="text" name="validade" id="inputDateStart" class="form-control datetimepicker-input data-input-mask" data-target="#dateStart"/>
                                            <div class="input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3 col-12">
                                        <label for="inputClasses" class="mb-0">Desconto ( em % )</label>
                                        <small class="form-text text-danger mt-0 mb-2">
                                            Digite o percentual de desconto do cupom
                                        </small>
                                       <input type="text" name="desconto" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 horizontal-right">
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
                            <h5 class="m-0 text-danger text-bold"><i class="fas fa-list"></i> Listagem de Cupons</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Aula</th>
                                            <th scope="col">Validade</th>
                                            <th scope="col">Desconto</th>
                                            <th scope="col">Código</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usuario->cupons as $cupom)
                                            <tr>
                                                <td scope="row">{{ $cupom->categoria->nome }}</td>
                                                <td>
                                                    @if( $cupom->aula()->exists() )
                                                        {{ $cupom->aula->categoria->nome . ' - ' . $cupom->aula->duracao . ' minutos - ' . currencyToApp($cupom->aula->valor) }}
                                                    @endif
                                                </td>
                                                <td>{{ dateBdToApp($cupom->validade) }}</td>
                                                <td>{{ $cupom->desconto }}%</td>
                                                <td><input id="codigo-cupom_{{ $loop->index }}" class="codigo-cupom" value="{{ $cupom->slug }}" readonly><button class="btn btn-sm btn-danger margin-left-20 btn-copy" data-toggle="tooltip" title="Copiar código do cupom"><i class="fas fa-copy"></i></button></td>
                                                <td>
                                                    <a class="mr-3 btn-alterar" href="#" data-url="{{ route('sistema.dash-professor.get', ['cupomaovivo', $cupom->id]) }}"><i class="fas fa-edit"></i></a>
                                                    <a href="#" data-url="{{ route('sistema.dash-professor.excluir', ['cupomaovivo', $cupom->id]) }}" data-texto="Confirma a exclusão deste cupom?" class="submit-single-post"><i class="fas fa-trash-alt"></i></a>
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
    <script src="{{assets('sistema/js/jquery.mask.js')}}"></script>        
    <script src="{{assets('plugins/js/masks.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection