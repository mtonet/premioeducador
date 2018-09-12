<?php

class DadosProfessorDAO {
	
	private $banco;
	
	public function DadosProfessorDAO() {
		$this->banco = new DAO('dao/config.xml');
	}
	
	public function insertDados($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades) {
		try {
			$this->banco->conecta();
			if ( isset($disciplina) ) {
				$this->banco->executaQuerySemRetorno("INSERT INTO dados_professor SET segmento='$segmento', disciplina='$disciplina', faixa_etaria_char='$faixa_etaria', ano_turma_char='$ano_turma', titulo='$titulo', numero_alunos='$numero', duracao='$duracao', ano_trabalho='$ano_trabalho', nece_especial='$necessidades', inscrito_id=$id");
			}
			else {
				$this->banco->executaQuerySemRetorno("INSERT INTO dados_professor SET segmento='$segmento', faixa_etaria_char='$faixa_etaria', ano_turma_char='$ano_turma', titulo='$titulo', numero_alunos='$numero', duracao='$duracao', ano_trabalho='$ano_trabalho', nece_especial='$necessidades', inscrito_id=$id");
			}
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosProfessorDAO) - MÉTODO insertDados()");
		}
	}

	public function updateDados($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades) {
		try {
			$this->banco->conecta();
			if ( isset($disciplina) ) {
				$this->banco->executaQuerySemRetorno("UPDATE dados_professor SET segmento='$segmento', disciplina='$disciplina', faixa_etaria_char='$faixa_etaria', ano_turma_char='$ano_turma', titulo='$titulo', numero_alunos='$numero', duracao='$duracao', ano_trabalho='$ano_trabalho', nece_especial='$necessidades' WHERE inscrito_id=$id");
			}
			else {
				$this->banco->executaQuerySemRetorno("UPDATE dados_professor SET segmento='$segmento', faixa_etaria_char='$faixa_etaria', ano_turma_char='$ano_turma', titulo='$titulo', numero_alunos='$numero', duracao='$duracao', ano_trabalho='$ano_trabalho', nece_especial='$necessidades' WHERE inscrito_id=$id");
			}
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosProfessorDAO) - MÉTODO updateDados()");
		}
	}
	
	public function verificaJaCadastrado($id) {
		try {
			$this->banco->conecta();
			$retorno = 0;
			
			$sql = "SELECT count(*) FROM dados_professor WHERE inscrito_id = $id";
			$retorno = $this->banco->executaQuery($sql);
			$row = mysql_fetch_row($retorno);
			
			$retorno = $row[0];
			
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (DadosProfessorDAO) - MÉTODO verificaJaCadastrado()");
		}
		
		return $retorno;
	}
	
	public function getDadosPorId($id) {
		try {
			$retorno = 0;
			$this->banco->conecta();
			$retorno = $this->banco->executaQuery("SELECT * FROM dados_professor WHERE id = $id");
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosProfessorDAO) - MÉTODO getDadosPorId()");
		}
		return $retorno;
	}
	
	public function getDadosPorIdInscrito($id) {
		try {
			$retorno = 0;
			$this->banco->conecta();
			$retorno = $this->banco->executaQuery("SELECT * FROM dados_professor WHERE inscrito_id = $id");
			$retorno = mysql_fetch_array($retorno);
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosProfessorDAO) - MÉTODO getDadosPorIdInscrito()");
		}
		return $retorno;
	}

}