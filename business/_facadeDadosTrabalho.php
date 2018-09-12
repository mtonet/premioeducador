<?
require_once('business/facadeInscrito.php');

class SessionFacadeDadosTrabalho {

	// Atualiza usuario
	// '0' - erro.
	public function insertDadosTrabalho($id, $fileName, $fileSize, $fileType) {
		try {
			$retorno = 0;
			$DadosTrabalhoDAO = new DadosTrabalhoDAO();
				
			$DadosTrabalhoDAO->insertDados($id, $fileName, $fileSize, $fileType);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}

	public function DadosTrabalho($id, $fileName, $tmpName, $fileSize, $fileType) {
		if ($fileSize < 0) {
			return -3;
		}
		
		if ($fileSize > 100000) {
			return -4;
		}
		
		$tmp = explode('.', $fileName);
		if ($tmp[1] != 'doc' && $tmp[1] != 'docx') {
			return -2;
		}
		
		try {
			$retorno = 0;
			$DadosTrabalhoDAO = new DadosTrabalhoDAO();
			$existe = $DadosTrabalhoDAO->verificaJaCadastrado($id);
			
			if ($existe == 0) {
				$ret = move_uploaded_file($tmpName, "upload/" . $fileName);
				if ($ret == false) {
					$retorno = -1;
				}
				else {
					$DadosTrabalhoDAO->insertDados($id, $fileName, $fileSize, $fileType);
				}
			}
			else {
				$ret = move_uploaded_file($tmpName, "upload/" . $fileName);
				if ($ret == false) {
					$retorno = -1;
				}
				else {
					$DadosTrabalhoDAO->updateDados($id, $fileName, $fileSize, $fileType);
				}
			}
				
			if ( isset($_SESSION['id']) && $existe == 0 ) {
				$InscritoFacade =  new SessionFacadeInscrito();
				$InscritoFacade->setPasso();
			}
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function verificaJaCadastrado($id) {
		try {
			$retorno = 0;
			$DadosTrabalhoDAO = new DadosTrabalhoDAO();
				
			$retorno = $DadosTrabalhoDAO->verificaJaCadastrado($id);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function getDadosPorIdInscrito($id) {
		try {
			$retorno = 0;
			
			$DadosTrabalhoDAO = new DadosTrabalhoDAO();
			$retorno = $DadosTrabalhoDAO->getDadosPorIdInscrito($id);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
}

?>