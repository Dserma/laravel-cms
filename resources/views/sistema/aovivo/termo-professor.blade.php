@extends('sistema.alunos.layouts.vazio')
@section('content')

  <section class="termos padding-bottom-30">  
    <div class="container-fluid limit">
        <div class="row margin-top-30 horizontal-center">
            <h1 class="text-black text-35-pt bold">Termos de Uso dos Professores</h1>
        </div>
        <div class="row margin-top-40 text-black text-14-pt regular line-24">
            {!! $conteudo->conteudo !!}
        </div>
    </div>
  </section>

@stop