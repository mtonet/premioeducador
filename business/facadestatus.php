<?php
//colocar no config e o dir ser uma variavel publica

require_once $_SERVER['DOCUMENT_ROOT'].'/dao/daoStatus.class.php';

class SessionFacadeStatus {

	function cadastraStatus($status, $inscrito_id, $usuario_id = 'NULL') {
		try {
			$retorno = 0;
			$StatusDAO = new StatusDAO();
			$StatusDAO->cadastraStatus($status, $inscrito_id, $usuario_id);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function getListById($id, $pagAtual=0, $pagLimite=0) {
		
		$retorno = null;
		
		try {
				$StatusDAO = new StatusDAO();	
				$retorno = $StatusDAO->getListById($id, $pagAtual, $pagLimite);
			}
			catch (Exception $e) 
			{
				$retorno = null;
			}
		
		return $retorno;
   }
}

?>