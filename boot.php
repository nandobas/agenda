<?php		 
		if(empty($_SESSION)){
			session_start();
		}	
	require_once 'inc/config.php';
	require_once 'model/mysql.php';
	require_once 'model/Session.class.php';
	require_once 'inc/funcoes.php';
	global $SITE_PATH;
	global $ROOT_PATH; 
?>