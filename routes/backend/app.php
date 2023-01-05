<?php
Route::group([
  'prefix' => '/backend',
], function () {
    Route::get('/', [
      'as' => 'backend.index',
      'uses' => 'Backend\AppController@index',
    ]);

    Route::get('/login', [
      'as' => 'backend.form',
      'uses' => 'Backend\LoginController@Form',
    ]);

    Route::post('/login', [
      'as' => 'backend.login',
      'uses' => 'Backend\LoginController@Index',
    ]);
});

Route::group([
  'middleware' => 'auth:backend',
  'prefix' => '/backend',
], function () {
    Route::get('/aulavod/{aulavod}/partituras', [
      'as' => 'backend.aulavod.partituras',
      'uses' => 'Backend\Aulasvod\AulavodController@partituras',
    ]);
    Route::get('/modulo/historico/{aluno}/{model}', [
      'as' => 'backend.aluno.historico',
      'uses' => 'Backend\AppController@subModulo',
    ]);

    Route::post('/aulavod/{aulavod}/partituras/upload', [
      'as' => 'backend.aulasvod.aulavod.partitura',
      'uses' => 'Backend\Aulasvod\AulavodController@upload',
    ]);

    Route::post('/aulavod/{aulavod}/partituras/apagar', [
      'as' => 'backend.aulasvod.aulavod.partitura.apagar',
      'uses' => 'Backend\Aulasvod\AulavodController@apagar',
    ]);

    Route::get('/aulavod/{aulavod}/backingtracks', [
      'as' => 'backend.aulavod.backingtracks',
      'uses' => 'Backend\Aulasvod\AulavodController@backingtracks',
    ]);

    Route::post('/aulavod/{aulavod}/backingtracks/upload', [
      'as' => 'backend.aulasvod.aulavod.backingtrack',
      'uses' => 'Backend\Aulasvod\AulavodController@uploadBackingtrack',
    ]);

    Route::post('/aulavod/{aulavod}/backingtracks/apagar', [
      'as' => 'backend.aulasvod.aulavod.backingtrack.apagar',
      'uses' => 'Backend\Aulasvod\AulavodController@apagarBackingtrack',
    ]);

    Route::get('/modulo/cursovod/{cursovod}/{model}', [
      'as' => 'backend.cursosvod.modulos',
      'uses' => 'Backend\AppController@subModulo',
    ]);

    Route::get('/modulo/subcategoria/{subcategoria}/{model}', [
      'as' => 'backend.categorias.grupos',
      'uses' => 'Backend\AppController@subModulo',
    ]);

    Route::get('/modulo/certificadovod/{certificadovod}/{model}', [
      'as' => 'backend.certificadovod.perguntas',
      'uses' => 'Backend\AppController@subModulo',
    ]);

    Route::post('/gallery/{model}/imagens/upload', [
      'as' => 'backend.gallery',
      'uses' => 'Backend\AppController@upload',
    ]);

    Route::post('/gallery/{model}/imagens/apagar', [
      'as' => 'backend.gallery.apagar',
      'uses' => 'Backend\AppController@apagarImage',
    ]);

    Route::get('/home', [
      'as' => 'backend.home',
      'uses' => 'Backend\HomeController@index',
    ]);

    Route::get('/sair', [
      'as' => 'sair',
      'uses' => 'Backend\LoginController@Sair',
    ]);

    Route::post('/upload', [
      'as' => 'backend.ajax.upload',
      'uses' => 'Backend\ImageController@Upload',
    ]);

    Route::post('/load', [
      'as' => 'backend.ajax.load',
      'uses' => 'Backend\ImageController@Load',
    ]);

    Route::delete('/delete', [
      'as' => 'backend.ajax.delete',
      'uses' => 'Backend\ImageController@Delete',
    ]);

    Route::get('/modulo/{model}/{acao?}', [
      'as' => 'backend.model',
      'uses' => 'Backend\AppController@Modulo',
    ]);

    Route::post('/{model}', [
      'as' => 'backend.adicionar',
      'uses' => 'Backend\AppController@Inserir',
    ]);

    Route::post('/{model}/save', [
      'as' => 'backend.salvar',
      'uses' => 'Backend\AppController@Alterar',
    ]);

    Route::post('/reordenar/{model}', [
      'as' => 'backend.reordenar',
      'uses' => 'Backend\AppController@Reordenar',
    ]);

    Route::get('/get/{model}/{action?}', [
      'as' => 'backend.get',
      'uses' => 'Backend\AppController@Get',
    ]);

    Route::get('/getsub/{model}/{pai}/{id}', [
      'as' => 'backend.get.sub',
      'uses' => 'Backend\AppController@getSub',
    ]);

    Route::get('/{model}/{id}/{action?}', [
      'as' => 'backend.editar',
      'uses' => 'Backend\AppController@Objeto',
    ]);

    Route::delete('/{model}/{id}', [
      'as' => 'backend.apagar',
      'uses' => 'Backend\AppController@Apagar',
    ]);
});
