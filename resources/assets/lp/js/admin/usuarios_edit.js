jQuery(function($){
	$("#UsuarioProfessor").change( function(){
		var UsuarioProfessor = $(this).val();
		if(UsuarioProfessor == 'S')
			$("#div_usuario").show();
		else{
			$("#div_usuario").hide();
			$("#UsuarioProfessorId").val("");
		}
	});

	loadGrig($("#UsuarioId").val());

	loadGrigBoleto($("#UsuarioId").val());

	loadGridPagamento($("#UsuarioId").val());

	loadGridCurso($("#UsuarioId").val());

	loadGrigPontuacao($("#UsuarioId").val());
});

//Validade de Acesso
function loadGrig(usuario_id){

	$.ajax({
		type: "POST",
		url:  URL + '/admin/usuarios/load_grid_validade/',
		data: {usuario_id: usuario_id},
		async: false,
		success: function(data) {
			$("#data_escolas").html(data);
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}

function addValidade(){
	var id 			= $("#validade_id").val();	
	var escola 		= $("#escola").val();	
	var data 		= $("#dob").val();	
	var usuario_id 	= $("#usuario_id").val();	
	
	$.ajax({
		type: "POST",
		url:  URL + '/admin/usuarios/validade_acesso/',
		data: {
			id: id, 
			escola: escola, 
			data: data, 
			usuario_id: usuario_id
		},
		async: false,
		success: function(data) {
		 	loadGrig(usuario_id);
						
			$("#validade_id").val("");
			$("#escola").val("");
			$("#dob").val("");
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});		
}


function deleteValidade(id){
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/delete_validade/',
		data: {id: id},
		async: false,
		success: function(data) {
			loadGrig($("#UsuarioId").val());
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}


//Boletos
function loadGrigBoleto(usuario_id){

	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/load_grid_boleto/',
		data: {usuario_id: usuario_id},
		async: false,
		success: function(data) {
			$(".grid_boletos").html(data);
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}

function addBoleto(){
	var plano 		= $("#plano").val();	
	var valor 		= $("#valor").val();	
	var data 		= $("#data_boleto").val();	
	var usuario_id  = $("#UsuarioId").val();	

	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/boleto/',
		data: {plano: plano, valor: valor, data: data, usuario_id: usuario_id},
		async: false,
		success: function(data) {
			loadGrigBoleto(usuario_id);
						
			$("#plano").val("");
			$("#valor").val("");
			$("#data").val("");
			$("#UsuarioId").val("");
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});		
}

function deleteBoleto(id){
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/delete_boleto/',
		data: {id: id},
		async: false,
		success: function(data) {
			loadGrigBoleto($("#UsuarioId").val());
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}

//Pagamentos
function loadGridPagamento(usuario_id){
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/load_grid_pagamento/',
		data: {usuario_id: usuario_id},
		async: false,
		success: function(data) {
			$(".grid_pagamentos").html(data);
		},
		error: function (xhr, ajaxOptions, thrownError) {
          	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}

function addPagamento(){
	var formData = {
	 	data_compra: 		$("#pagamento_data_compra").val(),	
	 	validade_acesso: 	$("#pagamento_validade_acesso").val(),	
	 	plano: 				$("#pagamento_plano").val(),
	 	metodo_pagamento: 	$("#pagamento_metodo_pagamento").val(),
	 	status: 			$("#pagamento_status").val(),	
	 	preco: 				$("#pagamento_preco").val(),	
	 	usuario_id:  		$("#pagamento_usuario_id").val(),	
	 	pagamento_id:  		$("#pagamento_id").val(),	
	 	pedido_id:  		$("#pedido_id").val(),	
	};
			
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/add_pagamento/',
		data: formData,
		async: false,
		success: function(data) {			
			loadGridPagamento($("#UsuarioId").val());		
						
			$("#pagamento_data_compra").val("");
			$("#pagamento_validade_acesso").val("");	
			$("#pagamento_plano").val("");
			$("#pagamento_metodos_pagamento").val("");
			$("#pagamento_status").val("");	
			$("#pagamento_preco").val("");
			$("#pagamento_id").val("");
			$("#pedido_id").val("");
		},
		error: function (xhr, ajaxOptions, thrownError) {
          	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});	
}	

function editPagamento( id ){
			
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/edit_pagamento/',
		data: { id: id },
		async: false,
		success: function(data) {			
			dados = eval("(" + data + ")");
			
			var dados_pedido 	= eval( "(" + dados.Pedido.dados_pedido + ")" );
			var amount 			= dados.Pagamento.price;

			$("#pagamento_data_compra").val( dados.Pedido.data_compra );
			$("#pagamento_validade_acesso").val( dados.Pedido.validade_acesso );	
			$("#pagamento_plano").val( dados.Plano.id );
			$("#pagamento_metodo_pagamento").val( dados.Pedido.metodo_pagamento );
			$("#pagamento_status").val( dados.Pedido.status );	
			$("#pagamento_preco").val( formatReal( amount.replace(".", "") ) );

			$("#pagamento_id").val( dados.Pagamento.id );
			$("#pedido_id").val( dados.Pedido.id );
		},
		error: function (xhr, ajaxOptions, thrownError) {
          	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});	
}		

function formatReal( int ) {
	var tmp = int + '';
	
	tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
	
	if( tmp.length > 6 )
		tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

	return tmp;
}

function deletePagamento(id){
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/delete_pagamento/',
		data: {id: id},
		async: false,
		success: function(data) {
			loadGridPagamento($("#UsuarioId").val());
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}

//Cursos
function loadGridCurso(usuario_id){
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/load_grid_curso/',
		data: {usuario_id: usuario_id},
		async: false,
		success: function(data) {			
			$(".grid_cursos").html(data);
		},
		error: function (xhr, ajaxOptions, thrownError) {
          	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}

function addCurso(){
	var formData = {
	 	curso: 			$("#curso").val(),		 	
	 	usuario_id:  	$("#usuario_id").val(),	
	};

	console.log(formData);
			
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/add_curso/',
		data: formData,
		async: false,
		success: function(data) {	
			loadGridCurso($("#UsuarioId").val());		
						
			$("#curso").val("");
		},
		error: function (xhr, ajaxOptions, thrownError) {
          	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});	
}

function deleteCurso(id){
	$.ajax({
		type: "POST",
		url: URL + '/admin/usuarios/delete_curso/',
		data: {id: id},
		async: false,
		success: function(data) {
			loadGridCurso($("#UsuarioId").val());
		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});						
}		
			

//Validade de Acesso
function loadGrigPontuacao(usuario_id){

	$.ajax({
		type: "POST",
		url:  URL + '/admin/usuarios/load_grid_pontuacao/',
		data: {usuario_id: usuario_id},
		async: false,
		success: function(data) {
			$( "#pontuacao_historico_id" ).val("");
			$( "#pontuacao_historico_id" ).val("");
			$( "#pontuacao_acao" ).val("add");
			$( "#pontuacao_usuario_indicado" ).val("");
			$( "#pontuacao_evento" ).val("");
			$( "#pontuacoes_plano" ).val("");

			$(".grid_pontuacao").html(data);

		},
		error: function (xhr, ajaxOptions, thrownError) {
        	console.log("Status: " + xhr.status);
          	console.log("Message: " + thrownError);
        }
	});	

}

function editPontuacao( id ){

	$.get(  URL + '/admin/usuarios/prepara_pontuacao_editar/' + id, function( data ) {

		d = data.split(',');

		$( "#pontuacao_historico_id" ).val( d[0] );
		$( "#pontuacao_acao" ).val( d[1] );
		$( "#pontuacao_usuario_indicado" ).val( d[2] );
		$( "#pontuacao_evento" ).val( d[3] );
		$( "#pontuacoes_plano" ).val( d[4] );

	});

}

function SavePontuacao( ){

	var formData = {
		usuario_id 					: $( "#UsuarioId" ).val(),
		pontuacao_historico_id 		: $( "#pontuacao_historico_id" ).val(),
		pontuacao_acao 				: $( "#pontuacao_acao" ).val(),
		pontuacao_usuario_indicado  : $( "#pontuacao_usuario_indicado" ).val(),
		pontuacao_evento 			: $( "#pontuacao_evento" ).val(),
		pontuacoes_plano			: $( "#pontuacoes_plano" ).val()

	};

	$.post(  URL + '/admin/usuarios/salva_pontuacao/', formData, function( data ) {
		
		loadGrigPontuacao($( "#UsuarioId" ).val());

	});

}

function deletePontuacao( id ){

	var formData = {
		usuario_id 					: $( "#UsuarioId" ).val(),
		pontuacao_historico_id 		: id,
	};

	$.post(  URL + '/admin/usuarios/delete_pontuacao/', formData, function( data ) {
		
		loadGrigPontuacao( $( "#UsuarioId" ).val() );

	});

}







			

			
					
			

			

			

			

			

			