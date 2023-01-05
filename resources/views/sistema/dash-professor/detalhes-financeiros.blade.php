@extends('sistema.layouts.vazio')
@section('content')

<section class="view_contact">
    <div class="view_contact_content">
        <div class="container">
          <div class="row horizontal-center text-red text-20-pt bold">
            {{ $titulo }}
          </div>
            <div class="row table-responsive">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Aluno</th>
                    <th>Aula</th>
                    <th>Valor</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($lista as $l)
                    <tr>
                      <td>{{ dateBdToApp($l->data) }} às {{ $l->inicio }} </td>
                      <td>{{ $l->aluno->fullName }}</td>
                      <td>{{ $l->aula->categoria->nome }} - {{ $l->aula->duracao }} minutos</td>
                      <td>{{ currencyToApp($l->valor_professor) }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</section>

@stop