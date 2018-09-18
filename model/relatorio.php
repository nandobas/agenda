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

class Relatorio{
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
				$action = 'Rel_ddd';
				if ( isset( $_GET['info'] ) )
				{
					$action = $_GET['info'];
				}
				$this->$action();
                break;
            case 'PUT':
                break;
            case 'POST':
            case 'DELETE':
                break;
            default:
                $this->header('HTTP/1.1 405 Method Not Allowed');
        }
    }

function Rel_ddd()
{
	global $db;
	
	$query = "
	
		SELECT tel_ddd, count( * ) AS qtd
		FROM telefones
		GROUP BY tel_ddd
	";
	$query_order = "
		ORDER BY 
			tel_ddd
	";
	
	//query contador totais
	$result = $db->query($query);
	$rowCount = $db->rowCount();
	//query principal
	$result = $db->query($query.$query_order); 

	$string["data"]=array();
	if ( $rowCount >= 1 )
	{
		
		while ($ObjTable = $result->fetch(PDO::FETCH_OBJ)){
			
			$string["data"][]=array("ddd"=> "(".$ObjTable->tel_ddd.")", "registros"=>$ObjTable->qtd);
		}
	}
	
	$data = array(
		"success"=>true,
		"mensagem"=>"mensagem",
		"data"=>$string["data"]
	);
	$data = jsonEncodeArray( $data );
	echo $data;
}


function Rel_uf()
{
	
	global $db;
	
	$query = "
	
		SELECT con_end_estado, count( * ) AS qtd
		FROM contatos
		GROUP BY con_end_estado
	";
	$query_order = "
		ORDER BY 
			con_end_estado
	";
	
	$query_conta = "
	
		SELECT count( * ) AS qtd
		FROM contatos
	";
	
	$result = $db->query($query_conta);
	$objTotal = $result->fetch(PDO::FETCH_OBJ);
	$total = $objTotal->qtd;
	
	//query contador totais
	$result = $db->query($query);	
	$rowCount = $db->rowCount();
	//query principal
	$result = $db->query($query.$query_order); 

	$string["data"]=array();
	if ( $rowCount >= 1 )
	{
		
		while ($ObjTable = $result->fetch(PDO::FETCH_OBJ)){
			$percent = (($ObjTable->qtd*100) / $total);
			$string["data"][]=array("label"=> $ObjTable->con_end_estado, "value"=>$percent);
		}
	}
	
	$data = array(
		"success"=>true,
		"mensagem"=>"mensagem",
		"data"=>$string["data"]
	);
	$data = jsonEncodeArray( $data );
	echo $data;
}

}

$Relatorio = new Relatorio();
?>