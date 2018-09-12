<?
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."dao/daoDadosTrabalho.class.php");
require_once($DIR.'business/facadeDadosTrabalho.php');

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

	public function setStatus($id, $status) {
		try {
			$retorno = 0;
			$DadosTrabalhoDAO = new DadosTrabalhoDAO();
				
			$DadosTrabalhoDAO->setStatus($id, $status);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	


	public function trataTxt($var) {

	$var = strtolower($var);
	
	$var = ereg_replace("[áàâãª]","a",$var);	
	$var = ereg_replace("[éèê]","e",$var);	
	$var = ereg_replace("[óòôõº]","o",$var);	
	$var = ereg_replace("[úùû]","u",$var);	
	$var = str_replace("ç","c",$var);
	
	return $var;
   }	


	public function DadosTrabalho($id, $fileName, $tmpName, $fileSize, $fileType) {
		if ($fileSize < 0) {
			return -3;
		}
		
		if ($fileSize > 100000) {
			return -4;
		}
		
		$tmp = explode('.', $fileName);
		if ($tmp[1] != 'doc' && $tmp[1] != 'docx' && $tmp[1] != 'pdf') {
			return -2;
		}
		
		try {
			$retorno = 0;
			$DadosTrabalhoDAO = new DadosTrabalhoDAO();
			$existe = $DadosTrabalhoDAO->verificaJaCadastrado($id);
			
			$Inscrito = new SessionFacadeInscrito();
			$inscrito = mysql_fetch_array($Inscrito->getDadosPorId($id));

			$fileName =  str_replace(" ", "",$fileName);
			
			$fileName = $inscrito['inscricao'] ."-".$fileName;
			//$fileName = $inscrito['inscricao'] ."-Arquivo.".$tmp[1];
			
			//$fileName = trataTxt($fileName);
			





			
			$_SESSION['arquivoSalvo'] = $fileName;
			
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