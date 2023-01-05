<?php

Route::group([
    'prefix' => '/ead',
  ], function () {
      Route::get('/assinatura/{planoSlug?}', [
        'as' => 'sistema.vod.assinatura.index',
        'uses' => 'Sistema\Cursosvod\CursosController@assinatura',
      ])->middleware('only-guest');
      Route::post('/assinatura', [
        'as' => 'sistema.vod.assinatura.cadastro',
        'uses' => 'Sistema\Alunos\AlunoController@cadastro',
      ]);
      Route::get('/assinatura-exterior', [
        'as' => 'sistema.vod.assinatura.exterior',
        'uses' => 'Sistema\Alunos\AlunoController@exterior',
      ]);
      Route::post('/plano/pagamento/cupom', [
        'as' => 'sistema.sua-conta.pagamento.cupom',
        'uses' => 'Sistema\Cursosvod\CursosController@cupom',
      ]);
      Route::get('/plano/pagamento/confirmacao', [
        'as' => 'sistema.sua-conta.confirmacao',
        'uses' => 'Sistema\Cursosvod\CursosController@pagamentoConfirmacao',
      ]);
      Route::get('/cursos/{categoriaVodSlug?}', [
        'as' => 'sistema.vod.index',
        'uses' => 'Sistema\Cursosvod\CursosController@index',
      ]);
      Route::get('/cursos/{categoriaVodSlug}/{cursoSlug}', [
        'as' => 'sistema.vod.curso',
        'uses' => 'Sistema\Cursosvod\CursosController@curso',
      ]);
      Route::post('/pagamentos/status', [
        'as' => 'sistema.pagamentos.vod.status',
        'uses' => 'Sistema\Cursosvod\CursosController@statusPagamento',
      ]);
      Route::post('/paypal/status', [
        'as' => 'sistema.vod.paypal.status',
        'uses' => 'Sistema\Cursosvod\CursosController@paypalStatus',
      ]);
      Route::post('/paypal/success', [
        'as' => 'sistema.vod.paypal.sucesso',
        'uses' => 'Sistema\Cursosvod\CursosController@paypalOK',
      ]);
  });

  Route::group([
    'prefix' => '/ead',
    'middleware' => 'auth',
  ], function () {
      Route::get('/cadastro/obrigado', [
        'as' => 'sistema.vod.assinatura.cadastro.obrigado',
        'uses' => 'Sistema\Alunos\AlunoController@cadastroObrigado',
      ]);
      Route::get('/cadastro/check/{planoSlug}', [
        'as' => 'sistema.vod.assinatura.check-cadastro',
        'uses' => 'Sistema\Alunos\AlunoController@checkCadastro',
      ]);
      Route::get('/plano/pagamento', [
        'as' => 'sistema.sua-conta.pagamento',
        'uses' => 'Sistema\Cursosvod\CursosController@pagamento',
      ]);
      Route::post('/remove-cupom', [
        'as' => 'sistema.vod.remove-cupom',
        'uses' => 'Sistema\Cursosvod\CursosController@removeCupom',
      ]);
      Route::post('/plano/pagamento/cartao', [
        'as' => 'sistema.vod.pagamento.cartao',
        'uses' => 'Sistema\Cursosvod\CursosController@pagamentoCartao',
      ]);
      Route::post('/plano/pagamento/boleto', [
        'as' => 'sistema.vod.pagamento.boleto',
        'uses' => 'Sistema\Cursosvod\CursosController@pagamentoBoleto',
      ]);
  });
