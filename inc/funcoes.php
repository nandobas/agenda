<?php

//require_once('connect.class.php');
$db=new ConnectionMysql();


function validaEmail($email) {
	$conta = '/^[a-zA-Z0-9\._-]+?@';
	$domino = '[a-zA-Z0-9_-]+?\.';
	$gTLD = '[a-zA-Z]{2,6}'; //.com; .coop; .gov; .museum; etc.
	$ccTLD = '((\.[a-zA-Z]{2,4}){0,1})$/'; //.br; .us; .scot; etc.
	$pattern = $conta.$domino.$gTLD.$ccTLD;
	if (preg_match($pattern, $email))
	return true;
	else
	return false;
}


/* **** Redirecionamento de pagina **** */
function Redirect($Destino)
{
    global $ADM_PATH;
    header("Location: $ADM_PATH/$Destino");
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}




function getNomeUsuario($usr_cod){
	$db=new ConnectionMysql();
	
	$query="
		SELECT usr_nome FROM usuarios
		WHERE 1
			AND usr_cod='".$usr_cod."'
		LIMIT 1";
	
	
	$result=$db->query($query);
	if($result && $usr_cod!=""){
		
		$ds = $result->fetch(PDO::FETCH_OBJ);
		return $ds->usr_nome;
	}
	
	return 'no title';
	
}

function getNomeContato($con_cod){
	$db=new ConnectionMysql();
	
	$query="
		SELECT con_nome FROM contatos
		WHERE 1
			AND con_cod='".$con_cod."'
		LIMIT 1";
	
	
	$result=$db->query($query);
	if($result && $con_cod!=""){
		
		$ds = $result->fetch(PDO::FETCH_OBJ);
		return $ds->con_nome;
	}
	
	return 'no title';
	
}


function toTagInfo($info){
	
    $str = preg_replace('/[áàãâä]/ui', 'a', $info);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str);
    $str = preg_replace("/[][><}{)(:;,!?*%~^`@]/", "", $str);
    $str = preg_replace("/ /", "_", $str);
    $str = strtolower($str);
	
	return $str;
	
}

function fulltrim( $str )
{
    return trim( preg_replace( '/\s+/', ' ', $str ) );
}


function jsonEncodeArray( $array ){
    //array_walk_recursive( $array, function(&$item) { 
       //$item = utf8_encode( $item ); 
       //$item = $item; 
    //});
    return json_encode( $array );
}


?>