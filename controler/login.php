<?php
$erro_login = array(
	1=>"Usuário não cadastrado",
	2=>"Erro na senha",
	3=>"Usuário não ativo"
);
function verificaTipoErroLogin($login){
	
	$db=new ConnectionMysql();	
	//$cod_erro=1;//login/email
	//$cod_erro=2;//senha
	
	$cod_erro=1;	
	$query_cli="
		SELECT usr_cod, usr_login FROM usuarios
		WHERE 1
			AND usr_login='".$login."'
		LIMIT 1";
		
	$query = $db->query($sql);
	$objUsuario = $query->fetch(PDO::FETCH_OBJ);
	if ( $db->rowCount() >= 1 )
	{	
		
		$array_usuario = array();
		$usr_cod = $objUsuario->usr_cod;
		$usr_login = $objUsuario->usr_login;
		
		$usr_login=strtoupper($usr_login);
		$login=strtoupper($login);
		
		if($usr_login==$login){
			//o erro é de senha
			$cod_erro=2;
		}
	}
	
	return $cod_erro;
	
}

function logar($user_login, $user_password){
	//users
	$sql = "select * from usuarios where usr_login = '$user_login' and usr_password = '$user_password'";
	$db=new ConnectionMysql();	
	
	$query = $db->query($sql);
	$objUsuario = $query->fetch(PDO::FETCH_OBJ);
    if ( $db->rowCount() >= 1 )
    {
		if($objUsuario->usr_ativo<>1){return array(false, 3);}
		$sid = new Session;
		$sid->init( 36000 );
		$sid->addNode( 'start', date( 'd/m/Y - h:i' ) );
		$sid->addNode( 'user_id', $objUsuario->usr_cod );
		$sid->addNode( 'user_nivel', $objUsuario->usr_nivel );
		$sid->addNode( 'user_login', $objUsuario->usr_login );
		$sid->addNode( 'user_nome', $objUsuario->usr_nome );
		return array(true, 0);
	}
			
	return array(false, 1);
}


if ( isset( $_GET['logout'] ) && !empty( $_GET['logout'] ) )
{
    $sid = new Session;
    $sid->destroy();
?>	
	<script> 
		window.location=SiteRoot;
	</script>
<?php 
}

if ( isset( $_POST['user_login'] ) && isset( $_POST['user_password'] ) && !empty( $_POST['user_login'] ) && !empty( $_POST['user_password'] ) )
{
    $user_password = md5( $_POST['user_password'] );
    $user_login = addslashes($_POST['user_login']);
	$return = logar($user_login, $user_password);

	if($return[0]<>true){?>
        <script> 
            $(document).ready(function () {
                notify('<?php echo $erro_login[$return[1]];?>', 'warning');

			});

        </script>
		
	<?php	
	}
?>	
	<script> 
		window.location=SiteRoot;
	</script>
<?php 		
}else{
	include("view/login.php");
}

?>