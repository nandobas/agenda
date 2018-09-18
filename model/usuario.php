<?php
require_once('../boot.php');
@header('Content-Type: application/json; charset=utf-8');	
	

$db = new ConnectionMysql;
$sid = new Session;
$sid->start();
$user_nivel = $sid->getNode('user_nivel');
$user_id = $sid->getNode('user_id');
		

if ( !$sid->check() )
{
    @header( 'Location: login.php' );
}

class Usuario{
	private $params = Array();

    public function __construct($options = null, $initialize = true, $error_messages = null) {
		
        if ($initialize) {
            $this->initialize(); 
        }
	}

    private function initialize() {
		$method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $this->load();
                break;
            case 'PUT':
				
				parse_str(file_get_contents('php://input'), $this->params);
				$action = 'updateAtivo';
				if ( isset( $_GET['action'] ) )
				{
					$action = $_GET['action'];
				}
				$this->$action();
                break;
            case 'POST':
                $this->insereRegistro();
                break;
            case 'DELETE':
                $this->delete($this->options['print_response']);
                break;
            default:
                $this->header('HTTP/1.1 405 Method Not Allowed');
        }
    }
function updateRegistro(){
	
	global $db;	
	$string["success"]=false;
	$string["mensagem"]='Erro para atualizar Usuário';
	
    if ( isset( $this->params['user_login'] ) && !empty( $this->params['user_login'] ) )
    {
        $user_id = $this->params['id'];
        $user_login = trim( $this->params['user_login'] );
        $user_nome = trim( $this->params['user_nome'] );
        $user_email = trim( $this->params['user_email'] );
        $user_nivel = trim( $this->params['user_nivel'] );
		$user_ativo=( (!isset($this->params["user_ativo"])) || ($this->params["user_ativo"]==''))?'0':'1';		

        $cond = " set usr_login = '$user_login', usr_nome = '$user_nome', usr_email = '$user_email', usr_nivel = '$user_nivel', usr_ativo = '$user_ativo' ";
        if ( isset( $this->params['user_password'] ) && $this->params['user_password'] != "" )
        {
            $user_password = md5( trim( $this->params['user_password'] ) );
            $cond .= ", usr_password = '$user_password' ";
        }
        $result = $db->query( "update usuarios  $cond where usr_cod = $user_id" );
		if($result){
			$string["success"]=true;
			$string["mensagem"]='Dados atualizados com sucesso.';
		}
    }
	
	$data = jsonEncodeArray( $string );
	echo $data;	
	
}
function insereRegistro(){
	global $db;	
	$string["success"]=false;
	$string["mensagem"]='Erro para inserir novo Usuário';
	
    if ( isset( $_POST['user_login'] ) && !empty( $_POST['user_login'] ) && isset( $_POST['user_password'] ) && !empty( $_POST['user_password'] ) )
    {
        $user_password = md5( trim( $_POST['user_password'] ) );
        $user_nome = trim( $_POST['user_nome'] );
        $user_login = trim( $_POST['user_login'] );
        $user_email = trim( $_POST['user_email'] );
        $user_nivel = trim( $_POST['user_nivel'] );
        $result = $db->query( "insert into usuarios (usr_login,usr_nome,usr_password,usr_email,usr_nivel,usr_ativo) values ('$user_login','$user_nome','$user_password','$user_email','$user_nivel',1);" );
        if($result){
			$string["success"]=true;
			$string["mensagem"]='Usuário cadastrado com sucesso';
		}
    }
	
	$data = jsonEncodeArray( $string );
	echo $data;
	
}

function updateAtivo(){
	
	global $db;	
	$string["success"]=false;
	$string["mensagem"]='Não foi possível atualizar';
	
	if ( isset( $this->params['user_id'] ) )
    {
		$get_user_id = explode("chk_", $this->params['user_id']);
		$user_id = $get_user_id[1];
		
		$user_ativo = (int) ($this->params['user_ativo'] == 1) ? 0 : 1;
		
		$query = "update usuarios set usr_ativo = $user_ativo where usr_cod = $user_id";
		$result = $db->query($query);
		if($result) {
			$string["success"]=true;
			if($user_ativo==1)
				$string["mensagem"]='Usuário foi ativado<Br/>';
			else
				$string["mensagem"]='Usuário desativado<Br/>';
		}
    }
	$data = jsonEncodeArray( $string );
	echo $data;
	
}

function load()
{
	global $db;
		
	//verificaLogin();
	
	$txt_criterio = "";	

	$TAMANHO_PAGINA = 5;
	
	if (isset($_GET["search"]["value"])){
		$criterio = fulltrim($_GET["search"]["value"]);
	}
	
	$tipo_order = "asc";
	$order_by = 'usr_login';
	
	$query = "
	
		SELECT 
			*
		FROM 
			usuarios
		WHERE 
			1=1
			{$txt_criterio}
	";
	$query_order = "
		ORDER BY 
			{$order_by} {$tipo_order}
	";
	$query_limit = "
		LIMIT 0,$TAMANHO_PAGINA
	";
	
	
	
	//query contador totais
	$result = $db->query($query);
	$rowCount = $db->rowCount();
	//query principal
	$result = $db->query($query.$query_order.$query_limit); 

	$string["data"]=array();
	if ( $rowCount >= 1 )
	{
		
		while ($ObjTable = $result->fetch(PDO::FETCH_OBJ)){
			
			$string["data"][]=
				array(
					0=>$ObjTable->usr_cod, 
					1=>$ObjTable->usr_login,
					2=>$ObjTable->usr_email,
					3=>$ObjTable->usr_ativo
				);
		}
	}
	$string["draw"]=1;
	$string["recordsTotal"]=$rowCount;
	$string["recordsFiltered"]=$rowCount;
	$data = jsonEncodeArray( $string );
	echo $data;
}

}

$Usuario = new Usuario();
?>