$(document).ready(function(){
    
    var confirmAtivo = 0;
	
	 
		function limpa_formulario_cep() {
                // Limpa valores do formulário de cep.
                $("#con_end_rua").val("");
                $("#con_end_bairro").val("");
                $("#con_end_cidade").val("");
                $("#con_end_estado").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#con_end_cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        //$("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#con_end_rua").val(dados.logradouro);
                                $("#con_end_bairro").val(dados.bairro);
                                $("#con_end_cidade").val(dados.localidade);
                                $("#con_end_estado").val(dados.uf);
                                //$("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulario_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulario_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulario_cep();
                }
            });
			
	//uppercase primeiro caracteres
	$('input[type="text"]').focusout(function(){
        var quebra = $(this).val().trim().split(/\s{1,}/);
        
        for(var i in quebra){
            quebra[i] = quebra[i].substr(0, 1).toUpperCase() + quebra[i].substring(1, quebra[i].length); 
        }
        
        var nome = "";
        for(var i in quebra)
            nome = nome + ' ' + quebra[i];
        
        $(this).val(nome.trim());
    });
	
	//pesquisa de contatos
	var dataTableContatos = $('#contatos').DataTable( {
		"ajax": {
            "url": "model/contato.php",
            "dataType": "json"
        },
		  'columns': [
			{data: 0, title: 'Cód'},
			{
				data: 1, 
				title: 'Nome',
				"render": function(data, type, row, meta){
					if(type === 'display'){
						data = '<a href="?action=contato&edit=' + row[0] + '">' + data + '</a>';

					}
					return data;
				}
					
			},
			{data: 2, title: 'Apelido'},
			{data: 3, title: 'Cadastro'},
			
			{
				data: 4, 
				title: 'Telefone',
				"render": function(data, type, row, meta){
					if(type === 'display'){
												
						data = '(' + row[4] + ')' + row[5];

					}
					return data;
				}
			},
			
			{
				data: 6, 
				title: 'Ativo',
				"render": function(data, type, row, meta){
					if(type === 'display'){
						var info_ativo = {0:'', 1:'checked'};
						
						data = '<input id="chk_'+row[0]+'" value="'+data+'" class="ativaContato" type="checkbox" name="con_ativo" '+info_ativo[data]+' title="Ativar/ Desativar" style="cursor:pointer;">';

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
		  $( "body" ).on( "click", ".ativaContato", setHandlerAtiva);
	}
	
    	
	//ativa ou desativa
	function setHandlerAtiva(){
		   var obj = this;
		   var con_cod = $(obj).attr('id');
		   var con_ativo = $(obj).val();
		   
		   var desc_ativo = 'ATIVAR';
		   if(con_ativo == 1)
				desc_ativo = 'DESATIVAR';
			
			if(confirmAtivo  != 1)
			{
						
				var msg  = '<ul class="dialog_ativar">';
				msg += '<br><h1>Você está prestes a '+desc_ativo+' este contato!</h1>';
				msg += '<br><p>Deseja realmente prosseguir?</p>';
				msg += '</ul>';
				
				
				BootstrapDialog.confirm(msg, function(result){
					if(result) {
							$.ajax({
								url: 'model/contato.php?action=updateAtivo',
								type: 'PUT',								
								data: {
									con_cod:con_cod,
									con_ativo:con_ativo
								},
								success: function(data) {
									notify(data.mensagem);						
						
									if(con_ativo == 1){
										$(obj).val(0);
									}else{
										$(obj).val(1);
									}
									if(confirmAtivo == 0)
									{
										var msg  = '<ul class="dialog_ativar">';
										msg += '<br><p>Deseja exibir a confirmação de ativação no próximo <br> contato que alterar?</p>';
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
						
							if(con_ativo == 1){
								$("#"+con_cod).prop('checked', true);
							}else{
								$("#"+con_cod).prop('checked', false);
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
						con_cod:con_cod,
						con_ativo:con_ativo
					},
					success: function(data){						
						
						if(con_ativo == 1){
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
	
	//mascaras	
	
	function setMaskOnChange(obj){
		var tipo =  parseInt($(obj).val());
		
		switch(tipo) {
			case 1:
			case 3:
				mask = "99 9999-9999";
				break;
			case 2:
				mask = "99 999-999-999";
				break;
			default:
				mask = "99 9999-9999";
		} 
		$(obj).closest('.clone').find("input[name*='tel_numero']").unmask();
		$(obj).closest('.clone').find("input[name*='tel_numero']").mask(mask);
	}
	
	$("select[name*='tel_tipo']").change(function(){setMaskOnChange(this)});
	
	//adiciona novo telefone
    $('#addtel').click(function(){
		$copia_tel = $(".telefone").clone(false);
		$($copia_tel).find(":input").attr("name", "tel_numero[]").removeAttr('id');
		$($copia_tel).find(":input").attr("value", " ").val('');
		$($copia_tel).find("select").attr("name", "tel_tipo[]").removeAttr('id').change(function(){setMaskOnChange(this)});
		$($copia_tel).find(".remove").removeAttr('for').removeAttr('id').click(function(){removeRegistroTelefone(this)});
		$copia_tel.removeClass( "telefone" );
		
		$copia_tel.appendTo("#package");
    });	

	
	$("#con_data_nascimento").mask("99/99/9999");	
  
  	/* ---------------------------------------------------------------------- */
	/*	btn Remove Registro
	/* ---------------------------------------------------------------------- */
	$(".remove").click(function(){removeRegistroTelefone(this)});		
	
	function removeRegistroTelefone(obj){
		var tel_cod =  $(obj).attr('id');
		var btn =  $(obj).attr('for');
		var getRemove = '?action=deleteTelefone';
		
		if(btn!='first' && tel_cod){
			$.ajax({
			   type: 'DELETE',
			   url: "model/contato.php"+getRemove,
			   data: {tel_cod:tel_cod},
			   success: function(msg)
			   {
					if(msg.success == true){
						notify(msg.mensagem, 'success');
					}
					else{
						notify(msg.mensagem, 'error');
					}
				}
			 });
		}
		
		if(btn!='first'){
			$(obj).closest('.clone').remove();
		}
	}
	
	
	/* ---------------------------------------------------------------------- */
	/*	Insere Registro
	/* ---------------------------------------------------------------------- */
	
	// Needed variables
	var $form 	= $('#form_dados_contato');
	
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
		   url: "model/contato.php"+get,
		   data: $(this).serialize(),
		   success: function(msg)
		   {
				if(msg.success == true){
					notify(msg.mensagem, 'success');
					//codigo registrado					
					con_cod = msg.con_cod;
					window.location=SiteRoot+'?action=contato&edit='+con_cod;
				}
				else{
					notify(msg.mensagem, 'error');
					if(msg.erros.length){
						var err = msg.erros;
						console.log(err);
						for (var i in err) {
							notify(err[i], 'error');
							console.log(err[i]);
						}
					}
				}
			}
		 });
		return false;
	});
	
	
											
})

function setMask(id, tipo, valor){
	
		var tipo =  parseInt(tipo);
		
		switch(tipo) {
			case 1:
			case 3:
				mask = "99 9999-9999";
				break;
			case 2:
				mask = "99 999-999-999";
				break;
			default:
				mask = "99 9999-9999";
		} 
	$("#"+id).mask(mask).val(valor);
}

