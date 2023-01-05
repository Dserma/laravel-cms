<?php

Route::group([
    'prefix' => '/',
  ], function () {
      Route::get('/evolucao', [
        'as' => 'sistema.evolucao',
        'uses' => 'Sistema\AppController@evolucao',
      ]);
      Route::get('/lp/acesso-completo', [
        'as' => 'sistema.completo',
        'uses' => 'Sistema\AppController@completo',
      ]);
      Route::get('/zoom', [
        'as' => 'sistema.zoom',
        'uses' => 'Sistema\AppController@zoom',
      ]);
      Route::get('/', [
        'as' => 'sistema.index',
        'uses' => 'Sistema\AppController@index',
      ]);
      Route::get('/auth', [
        'as' => 'sistema.auth',
        'uses' => 'Sistema\AppController@auth',
      ]);
      Route::get('/seja-aluno', [
        'as' => 'sistema.aluno',
        'uses' => 'Sistema\AppController@aluno',
      ]);
      Route::get('/aulas-ao-vivo/professor/{professoraovivoSlug}', [
        'as' => 'sistema.aluno.aovivo.professor',
        'uses' => 'Sistema\AppController@aulasAoVivoProfessor',
      ]);
      Route::get('/aulas-ao-vivo/{categoriaaovivoSlug?}', [
        'as' => 'sistema.aluno.aovivo',
        'uses' => 'Sistema\AppController@aulasAoVivo',
      ]);
      Route::get('/professores/{categoriaVodSlug?}', [
        'as' => 'sistema.professores.index',
        'uses' => 'Sistema\AppController@professores',
      ]);
      Route::get('/professores/{categoriaVodSlug}/{professorVodSlug}', [
        'as' => 'sistema.professor.index',
        'uses' => 'Sistema\AppController@professor',
      ]);
      Route::get('/seja-professor', [
        'as' => 'sistema.professor',
        'uses' => 'Sistema\AppController@sejaProfessor',
      ]);
      Route::get('/seja-professor/cadastro', [
        'as' => 'sistema.professor.cadastro',
        'uses' => 'Sistema\AppController@sejaProfessorCadastro',
      ]);
      Route::post('/seja-professor/cadastro', [
        'as' => 'sistema.professor.cadastrar',
        'uses' => 'Sistema\AppController@sejaProfessorCadastrar',
      ]);
      Route::get('/aulas-gratuitas', [
        'as' => 'sistema.aulas-gratuitas',
        'uses' => 'Sistema\AppController@aulasGratuitas',
      ]);
      Route::get('/quem-somos', [
        'as' => 'sistema.quem-somos',
        'uses' => 'Sistema\AppController@quemSomos',
      ]);
      Route::get('/ajuda', [
        'as' => 'sistema.ajuda',
        'uses' => 'Sistema\AppController@ajuda',
      ]);
      Route::get('/termos-de-uso', [
        'as' => 'sistema.termos',
        'uses' => 'Sistema\AppController@termos',
      ]);
      Route::get('/planos', [
        'as' => 'sistema.planos',
        'uses' => 'Sistema\AppController@planos',
      ]);
      Route::get('/blog', [
        'as' => 'sistema.blog',
        'uses' => 'Sistema\AppController@blog',
      ]);
      Route::get('/politica', [
        'as' => 'sistema.politica',
        'uses' => 'Sistema\AppController@politica',
      ]);
      Route::get('/quem-somos/nossa-historia', [
        'as' => 'sistema.historia',
        'uses' => 'Sistema\AppController@historia',
      ]);
      Route::get('/contato', [
        'as' => 'sistema.contato',
        'uses' => 'Sistema\AppController@contato',
      ]);
      Route::post('/contato', [
        'as' => 'sistema.contato.envia',
        'uses' => 'Sistema\AppController@contatoEnvia',
      ]);
      Route::get('/cadastro/confirmar/{usuario}/{token}', [
        'as' => 'sistema.usuario.confirmar',
        'uses' => 'Sistema\Alunos\AlunoController@confirmar',
      ]);
      Route::post('/login', [
        'as' => 'sistema.login',
        'uses' => 'Sistema\AppController@login',
      ]);
      Route::get('/recuperar-senha', [
        'as' => 'sistema.recuperar-senha',
        'uses' => 'Sistema\Auth\AuthController@senha',
      ]);
      Route::post('/recuperar-senha', [
        'as' => 'sistema.recuperar-senha.post',
        'uses' => 'Sistema\Auth\AuthController@senhaPost',
      ]);
      Route::get('/nova-senha/{aluno}/{token}', [
        'as' => 'sistema.nova-senha',
        'uses' => 'Sistema\Auth\AuthController@novaSenha',
      ]);
      Route::get('/nova-senha/professor/{professoraovivo}/{token}', [
        'as' => 'sistema.nova-senha.professor',
        'uses' => 'Sistema\Auth\AuthController@novaSenhaProfessor',
      ]);
      Route::post('/nova-senha/', [
        'as' => 'sistema.nova-senha.post',
        'uses' => 'Sistema\Auth\AuthController@novaSenhaPost',
      ]);
      Route::post('/nova-senha/professor/', [
        'as' => 'sistema.nova-senha.professor.post',
        'uses' => 'Sistema\Auth\AuthController@novaSenhaProfessorPost',
      ]);
      Route::post('/get-aulas/{professoraovivo}', [
        'as' => 'sistema.aovivo.getaulas',
        'uses' => 'Sistema\Aovivo\AovivoController@getAulas',
      ]);
      Route::post('/agenda-aula/{professoraovivo}', [
        'as' => 'sistema.aovivo.agendaaula',
        'uses' => 'Sistema\Aovivo\AovivoController@agendaAula',
      ]);
      Route::post('/cart/atualiza', [
        'as' => 'sistema.aovivo.atualizacart',
        'uses' => 'Sistema\Aovivo\AovivoController@atualizaCart',
      ]);
      Route::post('/cart/atualizatotal', [
        'as' => 'sistema.aovivo.atualizavalor',
        'uses' => 'Sistema\Aovivo\AovivoController@atualizaValor',
      ]);
      Route::post('/cart/remove/{aulaaovivo}', [
        'as' => 'sistema.aovivo.cart.remover',
        'uses' => 'Sistema\Aovivo\AovivoController@removeCart',
      ]);
      Route::post('/aovivo/pagamentos/status', [
        'as' => 'sistema.pagamentos.aovivo.status',
        'uses' => 'Sistema\Aovivo\AovivoController@statusPagamento',
      ]);
      Route::get('/aovivo/previa-agenda/{professoraovivo}', [
        'as' => 'sistema.aovivo.previa',
        'uses' => 'Sistema\Aovivo\AovivoController@previaAgenda',
      ]);
      Route::post('/aovivo/previa-agenda/{professoraovivo}/get', [
        'as' => 'sistema.aovivo.previa.get',
        'uses' => 'Sistema\Aovivo\AovivoController@previaAgendaGet',
      ]);
      Route::get('/aovivo/termos/professor', [
        'as' => 'sistema.aovivo.termo-professor',
        'uses' => 'Sistema\Aovivo\AovivoController@termoProfessor',
      ]);
  });

Route::group([
    'prefix' => '/',
    'middleware' => 'auth:web',
  ], function () {
      Route::get('/aovivo/pagar', [
      'as' => 'sistema.aovivo.pagar',
      'uses' => 'Sistema\Aovivo\AovivoController@pagar',
    ]);
  });
Route::group([
    'prefix' => '/',
    'middleware' => 'auth:web,professor',
  ], function () {
      Route::get('/sair', [
        'as' => 'sistema.sair',
        'uses' => 'Sistema\Alunos\AlunoController@sair',
      ]);
  });
