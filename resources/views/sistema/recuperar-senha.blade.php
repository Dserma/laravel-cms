@extends('sistema.layouts.vazio')
@section('content')

<section class="view_contact">
    <div class="view_contact_content">
        <div class="container">
            <form data-action="{{ route('sistema.recuperar-senha.post') }}" class="form-normal">
                <h2 class="text-red">Recuperação de senha</h2>
                <div class="form-group margin-top-10">
                    <label for="inputEmail">E-mail</label>
                    <input type="email" name="email" class="form-control" placeholder="Digite aqui...">
                </div>
                <button type="submit">Alterar Senha</button>
            </form>
        </div>
    </div>
</section>

@stop