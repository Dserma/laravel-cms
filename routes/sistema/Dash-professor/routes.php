<?php

  Route::group([
    'prefix' => '/dash-professor',
    'middleware' => 'auth:professor',
  ], function () {
      Route::get('/', [
        'as' => 'sistema.dash-professor.index',
        'uses' => 'Sistema\Professores\ProfessorController@index',
      ]);
      Route::get('/meus-dados', [
        'as' => 'sistema.dash-professor.dados',
        'uses' => 'Sistema\Professores\ProfessorController@meusDados',
      ]);
      Route::post('/meus-dados', [
        'as' => 'sistema.dash-professor.dados.salvar',
        'uses' => 'Sistema\Professores\ProfessorController@meusDadosSalvar',
      ]);
      Route::post('/meus-dados/imagens/{professoraovivo}', [
        'as' => 'sistema.dash-professor.imagens',
        'uses' => 'Sistema\Professores\ProfessorController@imagensUpload',
      ]);
      Route::post('/meus-dados/imagens/{professoraovivo}/apagar', [
        'as' => 'sistema.dash-professor.imagens.apagar',
        'uses' => 'Sistema\Professores\ProfessorController@imagemApagar',
      ]);
      Route::post('/avatar-upload/{professoraovivo}', [
        'as' => 'sistema.dash-professor.avatar.upload',
        'uses' => 'Sistema\Professores\ProfessorController@avatarUpload',
      ]);
      Route::get('/informacoes-financeiras', [
        'as' => 'sistema.dash-professor.financeiro',
        'uses' => 'Sistema\Professores\ProfessorController@financeiro',
      ]);
      Route::post('/informacoes-financeiras', [
        'as' => 'sistema.dash-professor.financeiro.salvar',
        'uses' => 'Sistema\Professores\ProfessorController@financeiroSalvar',
      ]);
      Route::get('/minha-agenda', [
        'as' => 'sistema.dash-professor.agenda',
        'uses' => 'Sistema\Professores\ProfessorController@agenda',
      ]);
      Route::get('/disponibilidade', [
        'as' => 'sistema.dash-disponibilidade',
        'uses' => 'Sistema\Professores\ProfessorController@disponibilidade',
      ]);
      Route::post('/disponibilidade', [
        'as' => 'sistema.dash-disponibilidade.salvar',
        'uses' => 'Sistema\Professores\ProfessorController@disponibilidadeSalvar',
      ]);
      Route::get('/aulas', [
        'as' => 'sistema.dash-professor.aulas',
        'uses' => 'Sistema\Professores\ProfessorController@aulas',
      ]);
      Route::post('/aulas', [
        'as' => 'sistema.dash-professor.aulas.salvar',
        'uses' => 'Sistema\Professores\ProfessorController@aulasSalvar',
      ]);
      Route::get('/pacotes', [
        'as' => 'sistema.dash-professor.pacotes',
        'uses' => 'Sistema\Professores\ProfessorController@pacotes',
      ]);
      Route::post('/pacotes', [
        'as' => 'sistema.dash-professor.pacotes.salvar',
        'uses' => 'Sistema\Professores\ProfessorController@pacotesSalvar',
      ]);
      Route::get('/cupons', [
        'as' => 'sistema.dash-professor.cupons',
        'uses' => 'Sistema\Professores\ProfessorController@cupons',
      ]);
      Route::get('/avaliacoes', [
        'as' => 'sistema.dash-professor.avaliacoes',
        'uses' => 'Sistema\Professores\ProfessorController@avaliacoes',
      ]);
      Route::post('/avaliacao/gravar', [
        'as' => 'sistema.dash-professor.avaliacao.gravar',
        'uses' => 'Sistema\Professores\ProfessorController@avaliacaoGravar',
      ]);
      Route::post('/cupons', [
        'as' => 'sistema.dash-professor.cupons.salvar',
        'uses' => 'Sistema\Professores\ProfessorController@cuponsSalvar',
      ]);
      Route::post('/get-aulas', [
        'as' => 'sistema.dash-professor.get-aulas',
        'uses' => 'Sistema\Professores\ProfessorController@getAulas',
      ]);
      Route::post('/transferencia', [
        'as' => 'sistema.dash-professor.transferencia',
        'uses' => 'Sistema\Professores\ProfessorController@transferencia',
      ]);
      Route::post('/excluir/{modelo}/{id}', [
        'as' => 'sistema.dash-professor.excluir',
        'uses' => 'Sistema\Professores\ProfessorController@excluir',
      ]);
      Route::post('/avaliacao/encerrar/{avaliacao}', [
        'as' => 'sistema.dash-professor.avaliacao.encerrar',
        'uses' => 'Sistema\Professores\ProfessorController@encerraDisputa',
      ]);
      Route::post('/avaliacao/reagendar/{avaliacao}', [
        'as' => 'sistema.dash-professor.avaliacao.reagendar',
        'uses' => 'Sistema\Professores\ProfessorController@reagendarAula',
      ]);
      Route::post('/avaliacao/reagendar-aula', [
        'as' => 'sistema.dash-professor.aula.reagendar',
        'uses' => 'Sistema\Professores\ProfessorController@reagendarAulaSemAvaliacao',
      ]);
      Route::post('/avaliacao/remover/{avaliacao}', [
        'as' => 'sistema.dash-professor.avaliacao.remover',
        'uses' => 'Sistema\Professores\ProfessorController@removerAvaliacao',
      ]);
      Route::post('/item/{modelo}/{id}/get', [
        'as' => 'sistema.dash-professor.get',
        'uses' => 'Sistema\Professores\ProfessorController@getItem',
      ]);
      Route::get('/informacoes-financeiras/alteracao/{professoraovivo}/{token}', [
        'as' => 'sistema.dash-professor.confirma-financeiro',
        'uses' => 'Sistema\Professores\ProfessorController@confirmaFinanceiro',
      ]);
      Route::post('/nova-categoria', [
        'as' => 'sistema.dash-professor.nova-categoria',
        'uses' => 'Sistema\Professores\ProfessorController@novaCategoria',
      ]);
      Route::post('/aovivo/aula/inicia', [
        'as' => 'sistema.professor.aovivo.aula.inicia',
        'uses' => 'Sistema\Alunos\AlunoController@iniciaAula',
      ]);
      Route::get('/informacoes-financeiras/detalhes/{professoraovivo}/{tipo}', [
        'as' => 'sistema.dash-professor.detalhes',
        'uses' => 'Sistema\Professores\ProfessorController@detalhes',
      ]);
      Route::post('/disponibilidades/reorder', [
        'as' => 'sistema.professor.disponibilidade.reorder',
        'uses' => 'Sistema\Professores\ProfessorController@reorder',
      ]);
  });
