<?
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."business/facadeInscrito.php");

class SessionFacadeDadosProfessor {

	// Atualiza usuario
	// '0' - erro.
	public function insertDadosProfessor($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades){
		try {
			$retorno = 0;
			$DadosProfessorDAO = new DadosProfessorDAO();
			$DadosProfessorDAO->insertDados($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}

	public function DadosProfessor($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades){
		try {
			$retorno = 0;
			$DadosProfessorDAO = new DadosProfessorDAO();
			$existe = $DadosProfessorDAO->verificaJaCadastrado($id);
			
			if($existe == 0)
				$DadosProfessorDAO->insertDados($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
			else
				$DadosProfessorDAO->updateDados($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
				
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
			$DadosProfessorDAO = new DadosProfessorDAO();
				
			$retorno = $DadosProfessorDAO->verificaJaCadastrado($id);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function getDadosPorIdInscrito($id) {
		try {
			$retorno = 0;
			
			$DadosProfessorDAO = new DadosProfessorDAO();
			$retorno = $DadosProfessorDAO->getDadosPorIdInscrito($id);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
}

?>