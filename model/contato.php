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
				
				parse_str(file_get_contents('php://input'), $this->params);
				$action = 'deleteTelefone';
				if ( isset( $_GET['action'] ) )
				{
					$action = $_GET['action'];
				}
				$this->$action();
                break;
            default:
                $this->header('HTTP/1.1 405 Method Not Allowed');
        }
    } 

function deleteTelefone(){
	
	global $db;	
	$string["success"]=false;
	$string["mensagem"]='Não foi possível remover registro';
	
	if ( isset( $this->params['tel_cod'] ) )
    {
		$get_tel_cod = explode("btn_", $this->params['tel_cod']);
		$tel_cod = $get_tel_cod[1];
		
		$query = "DELETE FROM telefones WHERE tel_cod = $tel_cod";
		$result = $db->query($query);
		if($result) {
			$string["success"]=true;
			$string["mensagem"]='Telefone foi removido<Br/>';
		}
    }
	$data = jsonEncodeArray( $string );
	echo $data;
	
}	

function updateRegistro(){
	
	global $db;	
	$string["success"]=false;
	$string["mensagem"]='Erro para atualizar Contato';
	
	$con_cod = $this->params['id'];
	
	$con_nome = trim( $this->params['con_nome']);
	$con_apelido = trim( $this->params['con_apelido']);
	$con_email = trim( $this->params['con_email'] );

	$con_end_cep = trim( $this->params['con_end_cep'] );
	$con_end_rua = trim( $this->params['con_end_rua'] );
	$con_end_complemento = trim( $this->params['con_end_complemento'] );
	$con_end_bairro = trim( $this->params['con_end_bairro'] );
	$con_end_cidade = trim( $this->params['con_end_cidade'] );
	$con_end_estado = trim( $this->params['con_end_estado'] );
	$con_data_nascimento = implode("-",array_reverse(explode("/",$this->params['con_data_nascimento'])));
	$con_observacao = stripslashes($this->params["con_observacao"]);
	$con_ativo=( (!isset($this->params["con_ativo"])) || ($this->params["con_ativo"]==''))?'0':'1';	
		
		//validações
		if(!$con_nome) {
			$err[] = 'Faltou nome';
		}
		if(!$con_apelido) {
			$err[] = 'Faltou apelido';
		}
		if(!$con_email) {
			$err[] = 'Faltou EMail';
		}
	
		// Check Info
		$pattern = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$^";
		if(!preg_match_all($pattern, $con_email, $out)) {
			$err[] = 'E-Mail invalido'; // Invalid email
		}	
	
		$updates = substr($this->params["indexs"], 0, -1); 
		$updates = explode(",", $updates);
        $values = "";
		$db = new ConnectionMysql;
		foreach($this->params["tel_numero"] as $idx=>$tel_numero){
			
			if(isset($tel_numero) && $tel_numero!=''){
				$info_tel = explode(" ",$tel_numero);
				$tel_ddd = $info_tel[0];
				$tel_numero = $info_tel[1];
				$tel_tipo = $this->params['tel_tipo'][$idx];
				
				$key = array_search($idx, $updates);
				if($updates[$key]==$idx){
						$query = "UPDATE telefones SET tel_ddd='$tel_ddd', tel_numero='$tel_numero', tel_tipo=$tel_tipo WHERE tel_cod=$idx";
						$result = $db->query( $query );
				}else{
						$query = "INSERT INTO telefones (tel_ddd, tel_numero, tel_tipo, con_cod) VALUES ('$tel_ddd', '$tel_numero', $tel_tipo, $con_cod)";
						$result = $db->query( $query );
				}
			}
		}	

        $cond = " 
			SET 
				con_nome = '$con_nome', 
				con_apelido = '$con_apelido', 
				con_email = '$con_email', 
				con_end_cep = '$con_end_cep', 
				con_end_rua = '$con_end_rua', 
				con_end_complemento = '$con_end_complemento', 
				con_end_bairro = '$con_end_bairro', 
				con_end_cidade = '$con_end_cidade', 
				con_end_estado = '$con_end_estado', 
				con_data_nascimento = '$con_data_nascimento', 
				con_observacao = '$con_observacao', 
				con_ativo = '$con_ativo' 
			";
			
        $result = $db->query( "UPDATE contatos  $cond WHERE con_cod = $con_cod" );
		if($result){
			$string["success"]=true;
			$string["mensagem"]='Dados atualizados com sucesso.';
			$string["con_cod"]=$con_cod;
		}
	
	$data = jsonEncodeArray( $string );
	echo $data;	
	
}
function insereRegistro(){
	global $db;	
	$string["success"]=false;
	$string["mensagem"]='Erro para inserir novo Contato';
	
        $con_nome = trim( $_POST['con_nome']);
        $con_apelido = trim( $_POST['con_apelido']);
        $con_email = trim( $_POST['con_email'] );
	
        $con_end_cep = trim( $_POST['con_end_cep'] );
        $con_end_rua = trim( $_POST['con_end_rua'] );
        $con_end_complemento = trim( $_POST['con_end_complemento'] );
        $con_end_bairro = trim( $_POST['con_end_bairro'] );
        $con_end_cidade = trim( $_POST['con_end_cidade'] );
        $con_end_estado = trim( $_POST['con_end_estado'] );
        $con_data_nascimento = implode("-",array_reverse(explode("/",$_POST['con_data_nascimento'])));
		$con_observacao = stripslashes($_POST["con_observacao"]);
		
		//validações
		if(!$con_nome) {
			$err[] = 'Faltou nome';
		}
		if(!$con_apelido) {
			$err[] = 'Faltou apelido';
		}
		if(!$con_email) {
			$err[] = 'Faltou EMail';
		}
	
		// Check Info
		$pattern = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$^";
		if(!preg_match_all($pattern, $con_email, $out)) {
			$err[] = 'E-Mail invalido'; // Invalid email
		}
			
		if(isset($err)){
			$string["erros"]=$err;
	
			$data = jsonEncodeArray( $string );
			echo $data;
			die("");
		}
		
		
			
			
		
		$query = "
			INSERT INTO contatos (
				con_nome,
				con_apelido,
				con_email,
				con_end_cep,
				con_end_rua,
				con_end_complemento,
				con_end_bairro,
				con_end_cidade,
				con_end_estado,
				con_data_nascimento,
				con_observacao) 
			VALUES (
				'$con_nome',
				'$con_apelido',
				'$con_email',
				'$con_end_cep',
				'$con_end_rua',
				'$con_end_complemento',
				'$con_end_bairro',
				'$con_end_cidade',
				'$con_end_estado',
				'$con_data_nascimento',
				'$con_observacao'
			);
		";   

		//echo 	$query;	
				
		$db = new ConnectionMysql;
		$stmt = $db->prepare($query);
        
		
		if ($stmt->execute())
		{
			$con_cod = $db->lastInsertId();
		
			//telefones
			$values ="";
			$query =" INSERT INTO telefones (con_cod, tel_tipo, tel_ddd, tel_numero) VALUES ";
			foreach($_POST["tel_numero"] as $key=>$tel_numero){
				if(isset($tel_numero) && $tel_numero!=''){
					$info_tel = explode(" ",$tel_numero);
					$tel_ddd = $info_tel[0];
					$tel_numero = $info_tel[1];
					$values.="($con_cod, ".$_POST["tel_tipo"][$key].", '$tel_ddd', '$tel_numero'),";
				}
			}
			
			$values  = substr_replace($values, ' ', -1);
			$query.= $values;
			
			$db = new ConnectionMysql;
			$db->query( $query );
		
		
			$string["success"]=true;
			$string["mensagem"]='Contato registrado com sucesso!';
			$string["con_cod"]=$con_cod;
		}
	
	$data = jsonEncodeArray( $string );
	echo $data;
	
}

function updateAtivo(){
	
	global $db;	
	$string["success"]=false;
	$string["mensagem"]='Não foi possível atualizar';
	
	if ( isset( $this->params['con_ativo'] ) )
    {
		$get_con_cod = explode("chk_", $this->params['con_cod']);
		$con_cod = $get_con_cod[1];
		
		$con_ativo = (int) ($this->params['con_ativo'] == 1) ? 0 : 1;
		
		$query = "update contatos set con_ativo = $con_ativo where con_cod = $con_cod";
		$result = $db->query($query);
		if($result) {
			$string["success"]=true;
			if($con_ativo==1)
				$string["mensagem"]='Contato foi ativado<Br/>';
			else
				$string["mensagem"]='Contato desativado<Br/>';
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
	$order_by = 'c.con_cod';
	
	$query = "
	
		SELECT 
			c.*,
			t.tel_ddd,
			t.tel_numero
		FROM 
			contatos c 				
				LEFT JOIN telefones t ON t.con_cod=c.con_cod AND (t.tel_cod = (SELECT max(tel_cod) FROM telefones WHERE con_cod=c.con_cod))
		WHERE 
			1=1
			{$txt_criterio}
	";
	$query_order = "
		ORDER BY 
			{$order_by} {$tipo_order}
	";
	$query_limit = "
		LIMIT 0, $TAMANHO_PAGINA
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
					0=>$ObjTable->con_cod, 
					1=>$ObjTable->con_nome,
					2=>$ObjTable->con_apelido,
					3=>$ObjTable->con_data_cadastro,
					4=>$ObjTable->tel_ddd,
					5=>$ObjTable->tel_numero,
					6=>$ObjTable->con_ativo
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