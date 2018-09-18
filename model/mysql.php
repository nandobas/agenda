<?php

/* autor: Fernando R. Basilio <fernando.basilio@gmail.com> */
/* Classe de conexão ao banco de dados MYSQL */
class ConnectionMysqlOld
{
    var $mysql=NULL;


    function ConnectionMysql(){
      
        $this->mysql=mysql_connect(SERVIDOR,USUARIO_BD,SENHA_BD)
                            or die("<H2><b>NÃO FOI POSSIVEL LOCALIZAR O SERVIDOR!!!<BR>ENTRE EM CONTATO COM O ADMINISTRADOR.</b></H2>");
		mysql_select_db(BASE);
    }
	
	function closeMysql(){
		mysql_close($this->mysql);
	}

}

/* autor: Fernando R. Basilio <fernando.basilio@gmail.com> */
/* Classe de conexão ao banco de dados MYSQL com PDO */
class ConnectionMysql extends PDO {

	function __construct( ) {
        include 'database.conf.php';
        global $databases;
        $this->driver = $databases['default'];			
			
		try {
			if ( !isset($this->handle)) {
				$dbh = parent::__construct("mysql:host=".$this->driver['host'].";dbname=".$this->driver['dbname'], $this->driver['user'], $this->driver['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
				$this->handle = $dbh;
				return $this->handle;
			}
		}
		catch ( PDOException $e ) {
			echo 'Connection failed: ' . $e->getMessage( );
			return false;
		}
	}

	function __destruct( ) {
		$this->handle = NULL;
	}
	
	function rowCount( ){
		
		$rs1 = $this->query('SELECT FOUND_ROWS()');
		$rowCount = (int) $rs1->fetchColumn();
		return $rowCount;
	}
}


/* end file */