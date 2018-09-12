<?
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."business/facadeInscrito.php");

class SessionFacadeDadosGestor {

	// Atualiza usuario
	// '0' - erro.
	public function insertDadosGestor($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades){
		try {
			$retorno = 0;
			$DadosGestorDAO = new DadosGestorDAO();
			$DadosGestorDAO->insertDados($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}

	public function DadosGestor($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades){
		try {
			$retorno = 0;
			$DadosGestorDAO = new DadosGestorDAO();
			$existe = $DadosGestorDAO->verificaJaCadastrado($id);
			
			if($existe == 0)
				$DadosGestorDAO->insertDados($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
			else
				$DadosGestorDAO->updateDados($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
				
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
	
	public function verificaJaCadastrado($id){
		try {
			$retorno = 0;
			$DadosGestorDAO = new DadosGestorDAO();
				
			$retorno = $DadosGestorDAO->verificaJaCadastrado($id);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function getDadosPorIdInscrito($id) {
		try {
			$retorno = 0;
			
			$DadosGestorDAO = new DadosGestorDAO();
			$retorno = $DadosGestorDAO->getDadosPorIdInscrito($id);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
}

?>