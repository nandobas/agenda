<?php
	
	$mostra_form = true;	
	if($user_nivel<>NIVEL_ADMINISTRADOR){
		die("Erro:Você não tem permissão para acessar este ambiente.");
	}
	
	if($mostra_form){
		
		if(isset($_GET['form'])){   	                                        
			$in_action = $_GET["form"];
		}
		
		if (file_exists("view/relatorio_".$in_action.".php")) {
			
			include("view/relatorio_".$in_action.".php");
		}
		else {
			die("Ops! Sorry Man\n");
		}
	}