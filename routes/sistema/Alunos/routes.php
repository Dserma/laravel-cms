<?php

Route::group([
  'prefix' => 'aluno',
], function () {
    Route::get('/aovivo/aula/finaliza', [
    'as' => 'sistema.alunos.aovivo.aula.finaliza',
    'uses' => 'Sistema\Alunos\AlunoController@finalizaAula',
  ]);
});

  Route::group([
    'prefix' => '/aluno',
    'middleware' => ['auth', 'check-pais'],
  ], function () {
      Route::get('/painel', [
        'as' => 'sistema.alunos.index',
        'uses' => 'Sistema\Alunos\AlunoController@index',
      ]);
      Route::get('/dados-pessoais/{pais?}', [
        'as' => 'sistema.alunos.dados',
        'uses' => 'Sistema\Alunos\AlunoController@dados',
      ]);
      Route::get('/meu-plano/status', [
        'as' => 'sistema.alunos.pagamentos',
        'uses' => 'Sistema\Alunos\AlunoController@statusPagamentos',
      ]);
      Route::get('/meu-plano/alterar/{alterar?}', [
        'as' => 'sistema.alunos.plano.alterar',
        'uses' => 'Sistema\Alunos\AlunoController@alterarPlano',
      ]);
      Route::get('/meu-plano/alterar-forma-pagamento', [
        'as' => 'sistema.alunos.plano.alterar.pagamento',
        'uses' => 'Sistema\Alunos\AlunoController@alterarPagamento',
      ]);
      Route::post('/dados-pessoais', [
        'as' => 'sistema.alunos.dados.salvar',
        'uses' => 'Sistema\Alunos\AlunoController@salvarDados',
      ]);
      Route::post('/upload/{aluno}', [
        'as' => 'sistema.alunos.upload',
        'uses' => 'Sistema\Alunos\AlunoController@upload',
      ]);
      Route::get('/ead/cursos-gratis', [
        'as' => 'sistema.alunos.cursos-gratis',
        'uses' => 'Sistema\Alunos\AlunoController@gratis',
      ]);
      Route::get('/curso-gratis/{cursoSlug}', [
        'as' => 'sistema.alunos.curso-gratis',
        'uses' => 'Sistema\Alunos\AlunoController@cursoGratis',
      ])->middleware('curso-gratis');
      Route::get('/ead/todos-os-cursos', [
        'as' => 'sistema.alunos.todos-cursos',
        'uses' => 'Sistema\Alunos\AlunoController@todosVod',
      ]);
      Route::get('/ead/curso/{cursoSlug}', [
        'as' => 'sistema.alunos.vod.curso',
        'uses' => 'Sistema\Alunos\AlunoController@cursoVod',
      ]);
      Route::get('/ead/curso/{cursoSlug}/player/{moduloSlug}/{aulaSlug}', [
        'as' => 'sistema.alunos.vod.curso.player',
        'uses' => 'Sistema\Alunos\AlunoController@cursoVodPlayer',
      ])->middleware('curso-assinatura');
      Route::post('/ead/curso/aula/concluida/{cursoSlug}/{moduloSlug}/{aulaSlug}', [
        'as' => 'sistema.alunos.vod.curso.aula.conclusao',
        'uses' => 'Sistema\Alunos\AlunoController@concluiAula',
      ])->middleware('usuario');
      Route::post('/ead/curso/aula/preferida/{modulovod}/{aulavod}', [
        'as' => 'sistema.alunos.vod.curso.aula.preferida',
        'uses' => 'Sistema\Alunos\AlunoController@aulaPreferida',
      ]);
      Route::get('/ead/meus-cursos', [
        'as' => 'sistema.alunos.meus-cursos',
        'uses' => 'Sistema\Alunos\AlunoController@meusCursos',
      ]);
      Route::post('/ead/meus-cursos/{cursovod}', [
        'as' => 'sistema.alunos.meus-cursos.apagar',
        'uses' => 'Sistema\Alunos\AlunoController@meusCursosApagar',
      ])->middleware('usuario');
      Route::get('/ead/materiais', [
        'as' => 'sistema.alunos.materiais',
        'uses' => 'Sistema\Alunos\AlunoController@materiais',
      ]);
      Route::post('/ead/get-modulos', [
        'as' => 'sistema.alunos.get-modulos',
        'uses' => 'Sistema\Alunos\AlunoController@getModulos',
      ]);
      Route::post('/ead/get-aulas', [
        'as' => 'sistema.alunos.get-aulas',
        'uses' => 'Sistema\Alunos\AlunoController@getAulas',
      ]);
      Route::post('/ead/get-materiais', [
        'as' => 'sistema.alunos.get-materiais',
        'uses' => 'Sistema\Alunos\AlunoController@getMateriais',
      ]);
      Route::get('/ead/material/download/partitura/{partitura}', [
        'as' => 'sistema.alunos.download.partitura',
        'uses' => 'Sistema\Alunos\AlunoController@downloadMaterial',
      ]);
      Route::get('/ead/material/download/backtrack/{backtrack}', [
        'as' => 'sistema.alunos.download.backtrack',
        'uses' => 'Sistema\Alunos\AlunoController@downloadMaterial',
      ]);
      Route::get('/ead/preferidos', [
        'as' => 'sistema.alunos.preferidos',
        'uses' => 'Sistema\Alunos\AlunoController@preferidos',
      ]);
      Route::post('/ead/pergunta/{cursoSlug}/{moduloSlug}/{aulaSlug}', [
        'as' => 'sistema.alunos.pergunta',
        'uses' => 'Sistema\Alunos\AlunoController@perguntaAula',
      ]);
      Route::get('/ead/certificados', [
        'as' => 'sistema.alunos.vod.certificados',
        'uses' => 'Sistema\Alunos\AlunoController@certificados',
      ]);
      Route::get('/ead/certificados/{certificado}', [
        'as' => 'sistema.alunos.vod.certificado',
        'uses' => 'Sistema\Alunos\AlunoController@certificado',
      ]);
      Route::get('/ead/certificados/{certificado}/refazer', [
        'as' => 'sistema.alunos.vod.certificado.refazer',
        'uses' => 'Sistema\Alunos\AlunoController@refazerAvaliacao',
      ]);
      Route::get('/ead/certificados/{certificado}/correcao', [
        'as' => 'sistema.alunos.vod.certificado.correcao',
        'uses' => 'Sistema\Alunos\AlunoController@certificadoCorrecao',
      ]);
      Route::get('/ead/certificados/{certificado}/gerar', [
        'as' => 'sistema.alunos.vod.certificado.gerar',
        'uses' => 'Sistema\Alunos\AlunoController@gerarCertificado',
      ]);
      Route::get('/ead/certificados/{certificado}/ver', [
        'as' => 'sistema.alunos.vod.certificado.ver',
        'uses' => 'Sistema\Alunos\AlunoController@verCertificado',
      ]);
      Route::post('/ead/certificados/{certificado}/{perguntacertificado}/responder', [
        'as' => 'sistema.alunos.vod.certificado.responder',
        'uses' => 'Sistema\Alunos\AlunoController@responderPerguntaCertificado',
      ]);
      Route::post('/ead/preferidos/adicionar/{cursoSlug}', [
        'as' => 'sistema.alunos.vod.preferido.adicionar',
        'uses' => 'Sistema\Alunos\AlunoController@adicionaPreferido',
      ])->middleware('usuario');
      Route::post('/ead/preferidos/remover/{cursoSlug}', [
        'as' => 'sistema.alunos.vod.preferido.remover',
        'uses' => 'Sistema\Alunos\AlunoController@removePreferido',
      ])->middleware('usuario');
      Route::post('/ead/assinatura/cancelar', [
        'as' => 'sistema.alunos.vod.assinatura.cancelar',
        'uses' => 'Sistema\Alunos\AlunoController@cancelarAssinatura',
      ]);
      Route::post('/ead/assinatura/cupom/check', [
        'as' => 'sistema.alunos.vod.check-cupom',
        'uses' => 'Sistema\Alunos\AlunoController@checkCupom',
      ]);
      Route::post('/ead/assinatura/trocar/{planoSlug}/{exibir?}', [
        'as' => 'sistema.alunos.vod.assinatura.trocar',
        'uses' => 'Sistema\Alunos\AlunoController@trocaAssinatura',
      ]);
      Route::post('/ead/assinatura/alterar/cartao', [
        'as' => 'sistema.alunos.vod.assinatura.alterar.cartao',
        'uses' => 'Sistema\Alunos\AlunoController@alteraAssinaturaCartao',
      ]);
      Route::post('/ead/assinatura/alterar/boleto', [
        'as' => 'sistema.alunos.vod.assinatura.alterar.boleto',
        'uses' => 'Sistema\Alunos\AlunoController@alteraAssinaturaBoleto',
      ]);
      Route::post('/aovivo/pagar/cartao', [
        'as' => 'sistema.alunos.aovivo.pagar.cartao',
        'uses' => 'Sistema\Alunos\AlunoController@aovivoPagarCartao',
      ]);
      Route::post('/aovivo/pagar/boleto', [
        'as' => 'sistema.alunos.aovivo.pagar.boleto',
        'uses' => 'Sistema\Alunos\AlunoController@aovivoPagarBoleto',
      ]);
      Route::get('/aovivo/pagamento/boleto', [
        'as' => 'sistema.alunos.aovivo.pagamento.boleto',
        'uses' => 'Sistema\Alunos\AlunoController@aovivoPagamentoBoleto',
      ]);
      Route::post('/aovivo/pedido/{pedidoaovivo}/cancelar', [
        'as' => 'sistema.alunos.aovivo.cupom',
        'uses' => 'Sistema\Alunos\AlunoController@cancelaPedidoAovivo',
      ]);
      Route::post('/aovivo/cupom', [
        'as' => 'sistema.alunos.aovivo.cupom',
        'uses' => 'Sistema\Aovivo\AovivoController@cupom',
      ]);
      Route::get('/aovivo/aulas', [
        'as' => 'sistema.alunos.aovivo.aulas',
        'uses' => 'Sistema\Alunos\AlunoController@aulas',
      ]);
      Route::get('/aovivo/agendar/pagas', [
        'as' => 'sistema.alunos.aovivo.agendar.pagas',
        'uses' => 'Sistema\Alunos\AlunoController@agendarPagas',
      ]);
      Route::post('/aovivo/agendar/pagas/disponibilidade/{agendamentoaluno}', [
        'as' => 'sistema.alunos.aovivo.agendar.pagas.disponibilidade',
        'uses' => 'Sistema\Alunos\AlunoController@agendarPagasDisponibilidade',
      ]);
      Route::post('/aovivo/agendar/pagas/disponibilidades/{agendamentoaluno}/{professoraovivo}/{aulaaovivo}', [
        'as' => 'sistema.alunos.aovivo.agendar.pagas.disponibilidade.professor',
        'uses' => 'Sistema\Alunos\AlunoController@agendarPagasDisponibilidadeProfessor',
      ]);
      Route::post('/aovivo/agendar/pagas/preagenda', [
        'as' => 'sistema.alunos.aovivo.agendar.pagas.pre-agenda',
        'uses' => 'Sistema\Alunos\AlunoController@preAgenda',
      ]);
      Route::post('/aovivo/agendar/pagas/agendar', [
        'as' => 'sistema.alunos.aovivo.agendar.pagas.agendar',
        'uses' => 'Sistema\Alunos\AlunoController@agendar',
      ]);
      Route::get('/aovivo/pagamentos', [
        'as' => 'sistema.alunos.aovivo.pagamentos',
        'uses' => 'Sistema\Alunos\AlunoController@pagamentosAoVivo',
      ]);
      Route::get('/aovivo/avaliacoes', [
        'as' => 'sistema.alunos.aovivo.avaliacoes',
        'uses' => 'Sistema\Alunos\AlunoController@avaliacoes',
      ]);
      Route::post('/aovivo/avaliacao/{avaliacao}/avaliar', [
        'as' => 'sistema.alunos.aovivo.avaliacao.avaliar',
        'uses' => 'Sistema\Alunos\AlunoController@avaliar',
      ]);
      Route::post('/aovivo/aula/inicia', [
        'as' => 'sistema.alunos.aovivo.aula.inicia',
        'uses' => 'Sistema\Alunos\AlunoController@iniciaAula',
      ]);
      Route::post('/ead/preferidos/get', [
        'as' => 'sistema.alunos.ead.preferidos.get',
        'uses' => 'Sistema\Alunos\AlunoController@getPreferidos',
      ]);
      Route::post('/ead/curso/aula/preferida/{modulovod}/{aulavod}/remover', [
        'as' => 'sistema.alunos.vod.curso.aula.preferida.remover',
        'uses' => 'Sistema\Alunos\AlunoController@removeAulaPreferida',
      ]);
      Route::post('/aovivo/reagendamento', [
        'as' => 'sistema.alunos.aovivo.reagendar',
        'uses' => 'Sistema\Alunos\AlunoController@reagendamento',
      ]);
  });
