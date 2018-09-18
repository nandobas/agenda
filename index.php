<?php
@header("Content-Type: text/html; charset=utf-8",true);
 

		 
		if(empty($_SESSION)){
			session_start();
		}
		
include("boot.php");
include("head.php");
$sid = new Session;
//$sid->start();


	$user_nivel = $sid->getNode('user_nivel');
	$user_id = $sid->getNode('user_id');
	$user_nome = $sid->getNode('user_nome');
?>
    <body>
	
	<nav class="header navbar navbar-inverse" >
	 
<div class="col-md-12">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Agenda - Gerenciador de Contatos</a>
    </div>
    <ul class="nav navbar-nav">
	<?php if($sid->check()){?>
	  <?php if($user_nivel == NIVEL_ADMINISTRADOR){?>
      <li id="li_index_contatos"><a href="index.php?action=contato">Contatos</a></li>
      <li id="li_index_usuario"><a href="index.php?action=usuario">Usuários</a></li>
	  <li class="dropdown" id="li_index_relatorio">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatórios <b class="caret"></b></a>
		<ul class="dropdown-menu animated fadeInUp">
		  <li><a href="index.php?action=relatorio&form=ddd">Por DDD</a></li>
		  <li><a href="index.php?action=relatorio&form=uf">Gráfico por UF</a></li>
		</ul>
	  </li>
	  <?php }?>
	  
	  
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="index.php?action=usuario&edit=<?php echo $user_id;?>"><span class="glyphicon glyphicon-user"></span> <?php echo $user_nome;?></a></li>
      <li><a href="?action=sair&logout=true"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
    </ul>
  </div>
  <?php }?>
</div>

	</nav> 
	

    <div class="page-content">





    	<div class="row">
		  
		  <div class="col-md-2" id="menu_esquerdo" style="display: none;">
		  	<div class="sidebar content-box" style="display: block;width:210px">
                <ul class="nav">
                    <?php 
						include("view/menu_agenda.php");
					?>
                </ul>
             </div>
		  </div>

<div id="conteudo" class="col-md-15">		  
 <?php
		global $action;
		global $ACT;
		
		//actions sem estar logado
		$action="home";
		
		if ( !$sid->check() )
		{
			$action='login';
		}
		
		if(isset($_GET['action'])){   	                                        
			$action = $_GET["action"];
			
			if($action=="sair"){
				$action="login";
			}
		}
		if (file_exists("controler/".$action.".php")) {
			if(isset($_GET["page_action"]))	{
				$ACT = $_GET["page_action"];
			}
			include("controler/".$action.".php");
		}
		else {
			die("Ops! Sorry Man\n");
		}
?>
</div>
		  
		</div>
    </div>

		<footer>
			 <div class="container">
			 
				<div class="copy text-center">
				   &copy; 2017 <a href='#'>Agenda</a>
				</div>
				
			 </div>
		</footer>

<script>	
	$("#li_<?php echo $action;?>").addClass( "current");
</script>
		
    </body>
</html>