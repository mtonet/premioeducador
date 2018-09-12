<?php
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."dao/daoStatus.class.php");

class SessionFacadeAtualizacao {
	
	public function getStatusById($id) {
		
		$retorno = null;
		
		try {
			$StatusDAO = new StatusDAO();	
			$retorno = $StatusDAO->getStatusById($id);
		}
		catch (Exception $e) {
			$retorno = null;
		}
		
		return mysql_fetch_array($retorno);
   }
}

?>