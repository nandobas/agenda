<?php
date_default_timezone_set('America/Sao_Paulo');
//configurações do sistema
//ini_set('display_errors',0);
//ini_set('display_startup_erros',0); 

$SITE_PATH="http://localhost:8080/agenda";
function get_full_url() {
	$https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
		!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
			strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
	return
		($https ? 'https://' : 'http://').
		(!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
		(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
		($https && $_SERVER['SERVER_PORT'] === 443 ||
		$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
		substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
}

$SITE_PATH = get_full_url();
$ROOT_PATH="C:/Easy53/www/agenda";


$ADM_PATH=$SITE_PATH."/setup";
$ADM=$ROOT_PATH."/setup";
$DAO=$ROOT_PATH."/inc";

//NIVEIS USUARIOS
define("NIVEL_VISITANTE", 			-1);
define("NIVEL_FUNCIONARIO",			1);
define("NIVEL_ADMINISTRADOR",		2);

global $NomeNivel;
$NomeNivel = array(
	NIVEL_VISITANTE		=> "Visitante",
	NIVEL_FUNCIONARIO	=> "Funcionario",
	NIVEL_ADMINISTRADOR	=> "Administrador"
);

//CONFIGURAÇÕES PARA ENVIO DE EMAIL
//define the receiver of the email
define('TO_EMAIL','fernando.basilio@gmail.com');

//define the subject of the email
define('SUBJECT','[AGENDA WEBSITE]');	

// Messages
define('MSG_INVALID_NAME','Escreva seu nome.');
define('MSG_INVALID_EMAIL','Entre com email valido.');
define('MSG_INVALID_MESSAGE','Escreva sua mensagem.');
define('MSG_SEND_ERROR','Desculpe, nao consegui enviar sua mensagem.');

?>