$(document).ready(function () {
	
	/* ---------------------------------------------------------------------- */
	/*	Contact Form
	/* ---------------------------------------------------------------------- */
	
	// Needed variables
	var $contactform 	= $('#contactform'),
		$success		= 'Sua Mensagem foi Enviada. Obrigado!';
		
	$contactform.submit(function(){
		$.ajax({
		   type: "POST",
		   url: "contact.php",
		   data: $(this).serialize(),
		   success: function(msg)
		   {
				if(msg == 'SEND'){
					response = '<div class="success">'+ $success +'</div>';
				}
				else{
					response = '<div class="error">'+ msg +'</div>';
				}
				// Hide any previous response text
				$(".error,.success").remove();
				// Show response message
				$contactform.prepend(response);
			}
		 });
		return false;
	});
	
		
	//ultimos cadastrados
	var dataTableUltimos = $('#ultimos').DataTable( {
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
			}
		  ],
		"language": {
            "url": "view/tpl/vendors/datatables/js/Portuguese-Brasil.json"
         }
	} );

});	


	
	
	function notify(msg, tipo){
		//warning
		//success
		//error
		$.sticky(
			msg, {
			stickyClass: tipo,
			speed:'slow',
			autoclose:1000
		});
	}
	

