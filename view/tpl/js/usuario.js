
$(document).ready(function(){
    
    var confirmAtivo = 0;
 
	//pesquisa de usuarios
	var dataTableusuarios = $('#usuarios').DataTable( {
		"ajax": {
            "url": "model/usuario.php",
            "dataType": "json"
        },
		  'columns': [
			{data: 0, title: 'ID'},
			{
				data: 1, 
				title: 'Login',
				"render": function(data, type, row, meta){
					if(type === 'display'){
						data = '<a href="?action=usuario&edit=' + row[0] + '">' + data + '</a>';

					}
					return data;
				}
					
			},
			{data: 2, title: 'E-Mail'},
			{
				data: 3, 
				title: 'Ativo',
				"render": function(data, type, row, meta){
					if(type === 'display'){
						var info_ativo = {0:'', 1:'checked'};
						
						data = '<input id="chk_'+row[0]+'" value="'+data+'" class="ativaUsuario" type="checkbox" name="user_ativo" '+info_ativo[data]+' title="Ativar/ Desativar" style="cursor:pointer;">';

					}
					return data;
				}
					
			}
		  ],
		"language": {
            "url": "view/tpl/vendors/datatables/js/Portuguese-Brasil.json"
         },
		"initComplete": function(sSource, aoData, fnCallback) {
			setTimeout(callHandlerAtiva, 2000);
		}
	} );
    
	function callHandlerAtiva(){
		  $( "body" ).on( "click", ".ativaUsuario", setHandlerAtiva);
	}
	
    	
	//ativa ou desativa
	function setHandlerAtiva(){
		   var obj = this;
		   var user_id = $(obj).attr('id');
		   var user_ativo = $(obj).val();
		   
		   var desc_ativo = 'ATIVAR';
		   if(user_ativo == 1)
				desc_ativo = 'DESATIVAR';
			
			if(confirmAtivo  != 1)
			{
						
				var msg  = '<ul class="dialog_ativar">';
				msg += '<br><h1>Você está prestes a '+desc_ativo+' este usuário!</h1>';
				msg += '<br><p>Deseja realmente prosseguir?</p>';
				msg += '</ul>';
				
				
				BootstrapDialog.confirm(msg, function(result){
					if(result) {
							$.ajax({
								url: 'model/usuario.php?action=updateAtivo',
								type: 'PUT',								
								data: {
									user_id:user_id,
									user_ativo:user_ativo
								},
								success: function(data) {
									notify(data.mensagem);						
						
									if(user_ativo == 1){
										$(obj).val(0);
									}else{
										$(obj).val(1);
									}
									if(confirmAtivo == 0)
									{
										var msg  = '<ul class="dialog_ativar">';
										msg += '<br><p>Deseja exibir a confirmação de ativação no próximo <br> usuário que alterar?</p>';
										msg += '</ul>'
										
										BootstrapDialog.confirm(msg, function(result){
											if(result) {
												confirmAtivo = 2;
											}else{
												confirmAtivo = 1;
											}
										});
										
									}
								}
							});
					}else {
						
							if(user_ativo == 1){
								$("#"+user_id).prop('checked', true);
							}else{
								$("#"+user_id).prop('checked', false);
							}
					}
				});
				
				
				
			}
			else
			{
				
				$.ajax({
					url: 'model/usuario.php?action=updateAtivo',
					type: 'PUT',								
					data: {
						user_id:user_id,
						user_ativo:user_ativo
					},
					success: function(data){						
						
						if(user_ativo == 1){
							$(obj).val(0);
						}else{
							$(obj).val(1);
						}
						notify(data.mensagem);                   
					} 
				});		
			}
	}
	//ativa ou desativa
	
	//selectall input 
	$(":password").on('mouseup', function() {
		$(this).select();
	});
	//selectall input 
	
	/* ---------------------------------------------------------------------- */
	/*	Insere Registro
	/* ---------------------------------------------------------------------- */
	
	// Needed variables
	var $form 	= $('#form_dados_usuario');
	
	var $act 	= $('#act').val();	
	
	var get = '';
	var type='POST';
	
	if($act=='atualiza'){
		type='PUT';
		get = '?action=updateRegistro';
	}
	$form.submit(function(){
		$.ajax({
		   type: type,
		   url: "model/usuario.php"+get,
		   data: $(this).serialize(),
		   success: function(msg)
		   {
				if(msg.success == true){
					notify(msg.mensagem, 'success');
					window.location=SiteRoot+'?action=usuario';
				}
				else{
					notify(msg.mensagem, 'error');
				}
			}
		 });
		return false;
	});
	
	
											
})

