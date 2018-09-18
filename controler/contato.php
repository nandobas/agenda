<script src="view/tpl/js/contato.js"></script>
<?php
	
	$mostra_form = false;
	if ( isset( $_GET['edit'] ) )
	{
		$mostra_form = true;
		$key = $_GET['edit'];	
		if($user_nivel<>NIVEL_ADMINISTRADOR){
			die("Erro:Você não tem permissão para acessar este registro.");
		}
	}	
	
	if ( isset( $_GET['novo'] ) )
	{
		$mostra_form = true;
	}
	
	if($mostra_form){
		$in_action = "contato";
		
		if(isset($_GET['form'])){   	                                        
			$in_action = $_GET["form"];
		}
		
		if (file_exists("view/form_".$in_action.".php")) {
			
			include("view/form_".$in_action.".php");
		}
		else {
			die("Ops! Sorry Man\n");
		}
	}
	elseif($user_nivel == NIVEL_ADMINISTRADOR)
	{	

		require_once('view/contato.php');

	} 
?>							

