<?
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."business/facadeInscrito.php");

class SessionFacadeDadosAcademicos {

	
	// Atualiza usuario
	// '0' - erro.
	public function insertDadosAcademicos($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao){
		try{
			$retorno = 0;
			$DadosAcademicosDAO = new DadosAcademicosDAO();
				
			$DadosAcademicosDAO->insertDados($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}

	
		public function DadosAcademicos($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao){
		try{
			$retorno = 0;
			$DadosAcademicosDAO = new DadosAcademicosDAO();
			$existe = $DadosAcademicosDAO->verificaJaCadastrado($id);
			
			if($existe == 0)
				$DadosAcademicosDAO->insertDados($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao);
			else
				$DadosAcademicosDAO->updateDados($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao);
		
			if ( isset($_SESSION['id']) && $existe == 0 ) {
				$InscritoFacade =  new SessionFacadeInscrito();
				$InscritoFacade->setPasso();
			}
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	
	public function verificaJaCadastrado($id){
		try{
			$retorno = 0;
			$DadosAcademicosDAO = new DadosAcademicosDAO();
				
			$retorno = $DadosAcademicosDAO->verificaJaCadastrado($id);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	
	
	public function getDadosPorIdInscrito($id) {
		try{
			$retorno = 0;
			
			$DadosAcademicosDAO = new DadosAcademicosDAO();
			$retorno = $DadosAcademicosDAO->getDadosPorIdInscrito($id);
			
		}
		catch(Exception $e){
			$retorno = -1;
			
		}
		
		return $retorno;
		
	}
	
	
	
}

?>